<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnboardingOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly mixed $user,
        public readonly string $code
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->code . ' is your Tagydes verification code',
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.onboarding.otp');
    }
}
