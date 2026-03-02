<?php

namespace App\Models;

use App\Provider;
use App\User;
use App\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequest extends Model
{
    protected $fillable = [
        'provider_id',
        'reseller_id',
        'customer_id',
        'user_id',
        'market',
        'currency',
        'list_type',
        'product_name',
        'sku',
        'offer_id',
        'notes',
        'urgency',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
