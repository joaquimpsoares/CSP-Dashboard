<?php

namespace App\Notifications;

use App\Models\ProductRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductRequestSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public ProductRequest $request,
        public ?string $customerName = null,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $name = $this->customerName ?: ('Customer #' . ($this->request->customer_id ?? '—'));
        $sku  = $this->request->sku ? " ({$this->request->sku})" : '';
        $urg  = $this->request->urgency ? strtoupper($this->request->urgency) : 'NORMAL';

        return [
            // database-notifications component expects ['data']
            'data' => "[{$urg}] Product request from {$name}: {$this->request->product_name}{$sku}",
            'product_request_id' => $this->request->id,
            'customer_id' => $this->request->customer_id,
            'reseller_id' => $this->request->reseller_id,
            'provider_id' => $this->request->provider_id,
            'sku' => $this->request->sku,
            'urgency' => $this->request->urgency,
        ];
    }
}
