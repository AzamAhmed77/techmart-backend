<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $name;
    public string $type; // 'registration' or 'password_reset'

    /**
     * Create a new message instance.
     */
    public function __construct(string $code, string $name = 'عزيزنا المستخدم', string $type = 'registration')
    {
        $this->code = $code;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->type === 'registration'
            ? 'تأكيد وتفعيل حسابك الجديد - TECH MART 🎉'
            : 'رمز استعادة كلمة المرور - TECH MART 🔐';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'code' => $this->code,
                'name' => $this->name,
                'type' => $this->type,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
