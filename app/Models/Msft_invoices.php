<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Msft_invoices extends Model
{
    use HasFactory;

    public function provider() {
        return $this->belongsTo('App\Provider');
    }

    public function instance() {
        return $this->belongsTo('App\Instance');
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function(Builder $query){
            $user = Auth::user();
            if($user && $user->userLevel->name === config('app.provider')){
                $query->whereHas('provider', function(Builder $query) use($user){
                    $query->where('id', $user->provider->id);
                });
            }
        });
    }
}
