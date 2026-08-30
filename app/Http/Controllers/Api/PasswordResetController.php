<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\PasswordResetCode;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    /**
     * Send OTP / Verification Code to user email.
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'البريد الإلكتروني غير صالح',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم نتمكن من العثور على حساب مسجل بهذا البريد الإلكتروني.',
            ], 404);
        }

        // Generate 6 digit numeric code
        $code = (string) random_int(100000, 999999);

        // Remove previous OTPs for this email
        PasswordResetCode::where('email', $email)->delete();

        // Store new OTP with 24 hours validity so it never expires prematurely
        PasswordResetCode::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        // Send email via Resend HTTP (instant ~200ms)
        try {
            \App\Services\EmailService::sendOtpEmail($email, $code, $user->name, 'password_reset');
        } catch (\Throwable $e) {
            Log::warning("Email sending error: " . $e->getMessage());
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إرسال رمز التحقق إلى بريدك الإلكتروني بنجاح.',
            'email'   => $email,
        ], 200);
    }

    /**
     * Verify the OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'code.required' => 'رمز التحقق مطلوب.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات التحقق غير مكتملة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $code = trim($request->code);

        $resetCode = PasswordResetCode::where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$resetCode) {
            return response()->json([
                'status' => 'error',
                'message' => 'رمز التحقق غير صحيح. يرجى التأكد من الرمز المدخل.',
            ], 400);
        }

        if ($resetCode->expires_at && Carbon::parse($resetCode->expires_at)->isPast()) {
            return response()->json([
                'status' => 'error',
                'message' => 'انتهت صلاحية رمز التحقق. يرجى طلب رمز جديد.',
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'رمز التحقق صحيح. يمكنك الآن تعيين كلمة المرور الجديدة.',
        ], 200);
    }

    /**
     * Reset the user password with a new password.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'code.required' => 'رمز التحقق مطلوب.',
            'password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن لا تقل عن 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات إعادة التعيين غير صالحة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $code = trim($request->code);

        $resetCode = PasswordResetCode::where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$resetCode) {
            return response()->json([
                'status' => 'error',
                'message' => 'رمز التحقق غير صحيح أو تم استخدامه مسبقاً.',
            ], 400);
        }

        if ($resetCode->expires_at && Carbon::parse($resetCode->expires_at)->isPast()) {
            return response()->json([
                'status' => 'error',
                'message' => 'انتهت صلاحية رمز التحقق. يرجى طلب رمز جديد.',
            ], 400);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'المستخدم غير موجود.',
            ], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Security: Revoke all existing session tokens on all devices
        $user->tokens()->delete();

        // Invalidate OTP
        PasswordResetCode::where('email', $email)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تمت إعادة تعيين كلمة المرور بنجاح، يمكنك الآن تسجيل الدخول بكلمة المرور الجديدة.',
        ], 200);
    }
}
