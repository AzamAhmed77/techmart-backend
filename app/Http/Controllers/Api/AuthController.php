<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\PasswordResetCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $email = strtolower(trim($request->email ?? ''));
        $request->merge(['email' => $email]);

        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'     => 'الاسم مطلوب.',
            'email.required'    => 'البريد الإلكتروني مطلوب.',
            'email.email'       => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min'      => 'كلمة المرور يجب أن لا تقل عن 6 أحرف.',
            'password.confirmed'=> 'تأكيد كلمة المرور غير مطابق.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'بيانات التسجيل غير صالحة',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::where('email', $email)->first();

            if ($user && $user->email_verified_at) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'هذا البريد الإلكتروني مسجل وموثق مسبقاً. يرجى تسجيل الدخول.',
                ], 422);
            }

            if ($user && !$user->email_verified_at) {
                // Update credentials for unverified user re-attempting registration
                $user->name = $request->name;
                $user->password = Hash::make($request->password);
                $user->save();
            } else {
                // Create user WITHOUT email_verified_at — awaiting OTP verification
                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $email,
                    'password' => Hash::make($request->password),
                ]);
            }

            // Generate and store verification OTP
            $code = (string) random_int(100000, 999999);
            PasswordResetCode::where('email', $user->email)->delete();
            PasswordResetCode::create([
                'email'      => $user->email,
                'code'       => $code,
                'expires_at' => Carbon::now()->addHours(24),
            ]);

            // Send verification email via Resend HTTP (instant ~200ms)
            try {
                \App\Services\EmailService::sendOtpEmail($user->email, $code, $user->name, 'registration');
            } catch (\Throwable $e) {
                Log::warning("Email sending error: " . $e->getMessage());
            }

            return response()->json([
                'status'  => 'pending_verification',
                'message' => 'تم إنشاء الحساب. يرجى التحقق من بريدك الإلكتروني وإدخال رمز التحقق.',
                'email'   => $user->email,
            ], 201);
        } catch (\Throwable $e) {
            Log::error("Registration error: " . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'حدث خطأ أثناء إنشاء الحساب، يرجى المحاولة لاحقاً.',
            ], 500);
        }
    }

    /**
     * Verify email OTP after registration and return auth token.
     */
    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'code'  => ['required', 'string', 'size:6'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'code.required'  => 'رمز التحقق مطلوب.',
            'code.size'      => 'رمز التحقق يجب أن يكون 6 أرقام.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'البيانات غير صالحة',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $user  = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'الحساب غير موجود.'], 404);
        }

        if ($user->email_verified_at) {
            // Already verified — just issue a token
            $token    = $user->createToken('auth_token')->plainTextToken;
            $userData = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'created_at' => $user->created_at];
            return response()->json(['status' => 'success', 'message' => 'البريد محقق بالفعل.', 'token' => $token, 'user' => $userData, 'data' => ['user' => $userData, 'token' => $token, 'token_type' => 'Bearer']]);
        }

        $record = PasswordResetCode::where('email', $email)->where('code', $request->code)->first();

        if (!$record) {
            return response()->json(['status' => 'error', 'message' => 'رمز التحقق غير صحيح.'], 400);
        }

        if ($record->expires_at < Carbon::now()) {
            $record->delete();
            return response()->json(['status' => 'error', 'message' => 'انتهت صلاحية رمز التحقق. يرجى طلب رمز جديد.'], 400);
        }

        // Mark email as verified and clean up OTP
        $user->email_verified_at = Carbon::now();
        $user->save();
        $record->delete();

        $token    = $user->createToken('auth_token')->plainTextToken;
        $userData = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'created_at' => $user->created_at];

        return response()->json([
            'status'  => 'success',
            'message' => 'تم التحقق من بريدك الإلكتروني وتسجيل الدخول بنجاح.',
            'token'   => $token,
            'user'    => $userData,
            'data'    => ['user' => $userData, 'token' => $token, 'token_type' => 'Bearer'],
        ], 200);
    }

    /**
     * Resend verification email OTP.
     */
    public function resendVerificationEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email'    => 'يرجى إدخال بريد إلكتروني صالح.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'البريد الإلكتروني مطلوب.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $user  = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'لم نتمكن من العثور على هذا الحساب.'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['status' => 'error', 'message' => 'هذا البريد تم تفعيله والتحقق منه بالفعل.'], 400);
        }

        // Generate new 6-digit OTP
        $code = (string) random_int(100000, 999999);
        PasswordResetCode::where('email', $email)->delete();
        PasswordResetCode::create([
            'email'      => $email,
            'code'       => $code,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        // Send email via Brevo HTTP API
        try {
            \App\Services\EmailService::sendOtpEmail($user->email, $code, $user->name, 'registration');
        } catch (\Throwable $e) {
            Log::warning("Resend email error: " . $e->getMessage());
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إعادة إرسال رمز التحقق إلى بريدك الإلكتروني بنجاح.',
            'email'   => $user->email,
        ], 200);
    }

    /**
     * Authenticate user & issue token.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات الدخول غير صالحة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', strtolower(trim($request->email)))->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
            ], 401);
        }

        // Block unverified accounts
        if (!$user->email_verified_at) {
            return response()->json([
                'status'  => 'email_not_verified',
                'message' => 'يرجى التحقق من بريدك الإلكتروني أولاً. تحقق من صندوق الوارد أو طلب إعادة إرسال الرمز.',
                'email'   => $user->email,
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الدخول بنجاح',
            'token' => $token,
            'user' => $userData,
            'data' => [
                'user' => $userData,
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }

    /**
     * Get authenticated user profile.
     */
    public function user(Request $request)
    {
        $user = $request->user();

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ];

        return response()->json([
            'status' => 'success',
            'user' => $userData,
            'data' => [
                'user' => $userData,
            ],
        ]);
    }

    /**
     * Logout and revoke token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الخروج بنجاح وحذف رمز الوصول',
        ], 200);
    }
}
