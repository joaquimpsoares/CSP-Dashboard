<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Pricing\ProviderPriceListDefault;
use App\Models\Pricing\ResellerPriceListAssignment;
use App\Models\Pricing\CustomerPriceListAssignment;

class PriceList extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'provider_id',
        'reseller_id',
        'name',
        'description',
        'source',
        'market',
        'currency',
        'list_type',
        'effective_from',
        'effective_to',
        'margin',
        'imported_at',
    ];

    protected $casts = [
        'effective_from' => 'datetime',
        'effective_to'   => 'datetime',
        'imported_at'    => 'datetime',
        'margin'         => 'decimal:2',
    ];

    public $dates = ['confirmed_changes_at'];

    // ── List type constants ─────────────────────────────────────────────────

    public const LIST_TYPE_LICENSE  = 'license_based';
    public const LIST_TYPE_AZURE    = 'azure_consumption';
    public const LIST_TYPE_ONE_TIME = 'one_time';

    public static function listTypes(): array
    {
        return [
            self::LIST_TYPE_LICENSE  => 'License-based',
            self::LIST_TYPE_AZURE    => 'Azure Consumption',
            self::LIST_TYPE_ONE_TIME => 'One-time / Perpetual',
        ];
    }

    // ── Scopes ──────────────────────────────────────────────────────────────

    /**
     * Price lists that are active and effective on a given date.
     * - Not soft-deleted (not archived).
     * - Has effective_from set (not draft).
     * - effective_from <= $date < effective_to (or effective_to is null).
     */
    public function scopeEffectiveOn(Builder $query, ?Carbon $date = null): Builder
    {
        $date ??= now();

        return $query
            ->whereNull('deleted_at')
            ->whereNotNull('effective_from')
            ->where('effective_from', '<=', $date)
            ->where(function (Builder $q) use ($date) {
                $q->whereNull('effective_to')->orWhere('effective_to', '>', $date);
            });
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    public function providerDefault()
    {
        return $this->hasOne(ProviderPriceListDefault::class);
    }

    public function resellerAssignments()
    {
        return $this->hasMany(ResellerPriceListAssignment::class);
    }

    public function customerAssignments()
    {
        return $this->hasMany(CustomerPriceListAssignment::class);
    }

    // ── Computed status ─────────────────────────────────────────────────────

    /**
     * Derive the display status from effective dates + soft-delete.
     * active   = not deleted, has effective_from, within [from, to)
     * draft    = not deleted, no effective_from (or from is in the future)
     * expired  = not deleted, effective_to <= now
     * archived = soft-deleted
     */
    public function getStatusAttribute(): string
    {
        if ($this->deleted_at) {
            return 'archived';
        }

        if (! $this->effective_from) {
            return 'draft';
        }

        $now = now();

        if ($this->effective_from > $now) {
            return 'draft';
        }

        if ($this->effective_to && $this->effective_to <= $now) {
            return 'expired';
        }

        return 'active';
    }

    // ── Legacy helpers ───────────────────────────────────────────────────────

    public function format()
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'prices'      => $this->prices(),
            'provider'    => $this->provider()->count(),
            'reseller'    => $this->reseller()->count(),
            'created_at'  => $this->created_at,
            'customer'    => 0,
        ];
    }

    // ── Global scope ────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::addGlobalScope('access_level', function (Builder $query) {
            $user = Auth::user();

            if (! $user) {
                return;
            }

            $level = $user->userLevel->name ?? null;

            if ($level === config('app.provider')) {
                $query->where('provider_id', $user->provider->id);
            }

            if ($level === config('app.reseller')) {
                // Show the reseller all of their provider's price lists so that
                // admins can manage assignments. Filtering by actual assignment
                // happens at the service layer (PriceListResolver).
                $providerId = $user->reseller?->provider_id;
                if ($providerId) {
                    $query->where('provider_id', $providerId);
                }
            }
        });
    }
}
