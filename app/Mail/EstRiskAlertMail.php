<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class EstRiskAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly mixed $provider,
        public readonly Collection $subscriptions,
        public readonly string $environment = 'live'
    ) {}

    public function build()
    {
        return $this->subject(
            '[Action Required] ' . $this->subscriptions->count() .
            ' subscription(s) at risk of EST auto-enrollment — April 1, 2026'
        )->markdown('emails.subscriptions.est-risk-alert')->with([
            'provider'      => $this->provider,
            'subscriptions' => $this->subscriptions,
            'environment'   => $this->environment,
        ]);
    }
}
