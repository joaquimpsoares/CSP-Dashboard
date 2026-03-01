<?php

namespace App\Models\Pricing;

use App\Customer;
use App\PriceList;
use App\Provider;
use App\Reseller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerPriceListAssignment extends Model
{
    protected $fillable = [
        'provider_id',
        'reseller_id',
        'customer_id',
        'price_list_id',
        'market',
        'currency',
        'list_type',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class);
    }

    // ── Business logic ───────────────────────────────────────────────────────

    /**
     * Set this assignment as the default, clearing any previous default
     * for the same (provider, customer, market, currency, list_type) tuple.
     */
    public function setAsDefault(): static
    {
        static::where('provider_id', $this->provider_id)
            ->where('customer_id', $this->customer_id)
            ->where('market', $this->market)
            ->where('currency', $this->currency)
            ->where('list_type', $this->list_type)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        $this->is_default = true;
        $this->save();

        return $this;
    }
}
