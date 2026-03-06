<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('access_level', function (Builder $query){
            $user = Auth::user();

            if (! $user || ! $user->userLevel) {
                return;
            }

            if ($user->userLevel->name === config('app.provider')) {
                if (! $user->provider) {
                    return;
                }

                $providerId = $user->provider->id;

                $query->where(function (Builder $q) use ($providerId) {
                    $q->where('provider_id', $providerId)
                      ->orWhereNull('provider_id');
                });
            }

            if ($user->userLevel->name === config('app.reseller')) {
                if (! $user->reseller) {
                    return;
                }

                $resellerId = $user->reseller->id;
                $providerId = optional($user->reseller->provider)->id;

                $query->where(function (Builder $q) use ($resellerId, $providerId) {
                    $q->where(function (Builder $q2) use ($resellerId, $providerId) {
                        $q2->where('reseller_id', $resellerId);
                        if ($providerId) {
                            $q2->where('provider_id', $providerId);
                        }
                    })
                    ->orWhereNull('provider_id')
                    ->orWhereNull('reseller_id');
                });
            }

            if ($user->userLevel->name === config('app.customer')) {
                // Relationship may not be loaded (or may be null). Use customer_id to resolve.
                $customer = $user->customer;

                if (! $customer && $user->customer_id) {
                    $customer = Customer::query()->with(['resellers.provider'])->find($user->customer_id);
                }

                $reseller = $customer?->resellers?->first();
                $providerId = $reseller?->provider?->id;

                if (! $reseller || ! $providerId) {
                    // If we cannot resolve the relationship, fall back to customer-only news.
                    $query->where('customer', true);
                } else {
                    $query->where(function (Builder $q) use ($providerId, $reseller) {
                        $q->where('provider_id', $providerId)
                          ->where('reseller_id', $reseller->id)
                          ->orWhere('customer', true);
                    });
                }

                $query->where(function (Builder $q) {
                    $q->where('expires_at', '>', date('Y-m-d'))
                      ->orWhereNull('expires_at');
                });
            }
        });
    }
}
