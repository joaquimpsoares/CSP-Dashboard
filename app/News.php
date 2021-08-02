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
        static::addGlobalScope('access_level', function (Builder $query) {
            $user = Auth::user();

            // if($user && $user->userLevel->name === config('app.super_admin')){
            //     $query->where('provider', true);
            // }
            if ($user && $user->userLevel->name === config('app.provider')) {
                $query->where('provider_id', $user->provider->id);
                $query->orwhere('provider', true);
                $query->where('expires_at', '>', date('Y-m-d'));
                $query->orwhere('expires_at', null);
            }
            if ($user && $user->userLevel->name === config('app.reseller')) {
                $query->where('reseller_id', $user->reseller->id);
                // $query->where('expires_at', null);
                // $query->where('expires_at', '>', date('Y-m-d') ?? null);
            }
            if ($user && $user->userLevel->name === config('app.customer')) {
                $query->where('provider_id', $user->customer->resellers->first()->provider->id);
                $query->where('reseller_id', $user->customer->resellers->first()->id);
                $query->orwhere('customer', true);
                $query->where('expires_at', '>', date('Y-m-d'));
                $query->orwhere('expires_at', null);
            }
        });
    }
}
