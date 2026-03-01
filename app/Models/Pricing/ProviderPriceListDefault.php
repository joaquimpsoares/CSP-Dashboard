<?php

namespace App\Models\Pricing;

use App\PriceList;
use App\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderPriceListDefault extends Model
{
    protected $fillable = [
        'provider_id',
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

    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class);
    }

    // ── Business logic ───────────────────────────────────────────────────────

    /**
     * Set this record as the default for its (provider, market, currency, list_type)
     * tuple, clearing any previous default first to enforce uniqueness at app level.
     */
    public function setAsDefault(): static
    {
        static::where('provider_id', $this->provider_id)
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
