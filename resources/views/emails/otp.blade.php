<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECH MART</title>
</head>
<body style="margin: 0; padding: 15px 5px; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; direction: rtl; text-align: right; -webkit-font-smoothing: antialiased;">
    
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 440px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <!-- Header -->
        <tr>
            <td align="center" style="background-color: #4f46e5; padding: 24px 15px; text-align: center;">
                <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td align="center" style="color: #ffffff; font-size: 20px; font-weight: 800; letter-spacing: 1px;">
                            ⚡ TECH MART
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 24px 20px; text-align: center;">
                
                <h3 style="margin: 0 0 10px 0; font-size: 18px; font-weight: 700; color: #1e293b;">
                    مرحباً {{ $name ?? 'عزيزنا العميل' }} 👋
                </h3>

                <p style="margin: 0 0 18px 0; font-size: 14px; line-height: 1.6; color: #64748b;">
                    @if(($type ?? 'registration') === 'registration')
                        استخدم رمز التحقق التالي لتفعيل حسابك في <strong>TECH MART</strong>:
                    @else
                        استخدم رمز التحقق التالي لإعادة تعيين كلمة المرور الخاصة بحسابك:
                    @endif
                </p>

                <!-- Clean OTP Code Box -->
                <table role="presentation" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 16px auto;">
                    <tr>
                        <td align="center" style="background-color: #f8fafc; border: 2px dashed #4f46e5; border-radius: 12px; padding: 12px 24px;">
                            <span style="font-size: 28px; font-weight: 800; letter-spacing: 8px; color: #4f46e5; font-family: monospace; display: inline-block;">
                                {{ $code }}
                            </span>
                        </td>
                    </tr>
                </table>

                <p style="margin: 14px 0 0 0; font-size: 12px; color: #94a3b8; font-weight: 500;">
                    ⏱️ صالح للاستخدام لمدة 24 ساعة
                </p>

                <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 11px; color: #94a3b8; line-height: 1.5;">
                    إذا لم تطلب هذا الرمز، يمكنك تجاهل هذا البريد بأمان.
                </div>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="background-color: #f8fafc; padding: 14px 15px; border-top: 1px solid #e2e8f0; text-align: center;">
                <div style="font-size: 11px; color: #94a3b8;">
                    © 2026 <strong>TECH MART</strong> Mobile App
                </div>
            </td>
        </tr>

    </table>

</body>
</html>
