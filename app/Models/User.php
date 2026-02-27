<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Webpatser\Countries\Countries;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, Notifiable, HasRoles, Impersonate;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'country' => $this->country,
            'provider' => $this->provider,
            'reseller' => $this->reseller,
            'customer' => $this->customer,
        ];
    }

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function userLevel()
    {
        return $this->belongsTo(UserLevel::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    // protected static function booted(){
    //     static::addGlobalScope('access_level', function(Builder $query){
    //         $user = Auth::user();
    //         if($user && $user->userLevel->name === config('app.provider')){
    //             $query->whereHas('customer', function(Builder $query) use($user){
    //                 $query->whereHas('resellers', function(Builder $query) use($user){
    //                     $query->whereHas('provider', function(Builder $query) use($user){
    //                         $query->where('id', $user->provider->id);
    //                     });
    //                 });
    //             });
    //         }
    //         if($user && $user->userLevel->name === config('app.reseller')){
    //             $query->whereHas('customer', function(Builder $query) use($user){
    //                 $query->whereHas('resellers', function(Builder $query) use($user){
    //                     $query->where('id', $user->reseller->id);
    //                 });
    //             });
    //         }
    //         if($user && $user->userLevel->name === config('app.customer')){
    //             $query->whereHas('customer', function(Builder $query) use($user){
    //                 $query->where('id', $user->customer->id);
    //             });
    //         }
    //     });
    // }
}
