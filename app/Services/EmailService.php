<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;

class EmailService
{
    /**
     * Send OTP verification or password reset email.
     * Uses Brevo (Sendinblue) HTTP API (primary) with fallback to Resend & Laravel Mail.
     */
    public static function sendOtpEmail(string $email, string $code, string $name = 'عزيزنا المستخدم', string $type = 'registration'): bool
    {
        $brevoApiKey = env('BREVO_API_KEY', config('services.brevo.key', ''));
        $resendApiKey = env('RESEND_API_KEY', config('services.resend.key', ''));
        // The sender email for Brevo MUST be the email registered on Brevo (azamahemdali2@gmail.com)
        $senderEmail = 'azamahemdali2@gmail.com';
        $senderName = env('MAIL_FROM_NAME', 'TECH MART');

        $subject = $type === 'registration'
            ? 'تأكيد وتفعيل حسابك الجديد - TECH MART 🎉'
            : 'رمز استعادة كلمة المرور - TECH MART 🔐';

        // Render Blade template to HTML
        try {
            $htmlContent = view('emails.otp', [
                'code' => $code,
                'name' => $name,
                'type' => $type,
            ])->render();
        } catch (\Throwable $e) {
            Log::error("Failed to render email template: " . $e->getMessage());
            $htmlContent = "<h2>TECH MART</h2><p>رمز التحقق الخاص بك هو: <strong>{$code}</strong></p>";
        }

        // ==========================================
        // 1. PRIMARY: Brevo HTTP API (Supports sending to ANY recipient in the world)
        // ==========================================
        if (!empty($brevoApiKey)) {
            try {
                $response = Http::withOptions([
                        'verify'           => false,
                        'force_ip_resolve' => 'v4',
                    ])
                    ->withHeaders([
                        'api-key'      => $brevoApiKey,
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json',
                    ])
                    ->timeout(15)
                    ->post('https://api.brevo.com/v3/smtp/email', [
                        'sender' => [
                            'name'  => $senderName,
                            'email' => $senderEmail,
                        ],
                        'to' => [
                            [
                                'email' => $email,
                                'name'  => $name,
                            ],
                        ],
                        'subject'     => $subject,
                        'htmlContent' => $htmlContent,
                    ]);

                if ($response->successful()) {
                    Log::info("Email sent successfully via Brevo HTTP to {$email} (Type: {$type})");
                    return true;
                } else {
                    Log::warning("Brevo HTTP API error for {$email}: " . $response->body());
                }
            } catch (\Throwable $e) {
                Log::warning("Brevo HTTP request failed for {$email}: " . $e->getMessage());
            }
        }

        // ==========================================
        // 2. SECONDARY: Resend HTTP API
        // ==========================================
        if (!empty($resendApiKey)) {
            try {
                $resendFrom = 'onboarding@resend.dev';
                $response = Http::withOptions([
                        'verify'           => false,
                        'force_ip_resolve' => 'v4',
                    ])
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $resendApiKey,
                        'Content-Type'  => 'application/json',
                    ])
                    ->timeout(15)
                    ->post('https://api.resend.com/emails', [
                        'from'    => "{$senderName} <{$resendFrom}>",
                        'to'      => [$email],
                        'subject' => $subject,
                        'html'    => $htmlContent,
                    ]);

                if ($response->successful()) {
                    Log::info("Email sent successfully via Resend HTTP to {$email} (Type: {$type})");
                    return true;
                } else {
                    Log::warning("Resend HTTP API returned error for {$email}: " . $response->body());
                }
            } catch (\Throwable $e) {
                Log::warning("Resend HTTP request failed for {$email}: " . $e->getMessage());
            }
        }

        // ==========================================
        // 3. FALLBACK: Laravel Standard Mailer
        // ==========================================
        try {
            Mail::to($email)->send(new OtpVerificationMail($code, $name, $type));
            Log::info("Email sent via Laravel Mailer to {$email}");
            return true;
        } catch (\Throwable $e) {
            Log::error("All email sending methods failed for {$email}: " . $e->getMessage());
            return false;
        }
    }
}
