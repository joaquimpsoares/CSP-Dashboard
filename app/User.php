<?php

namespace App;

use Soved\Laravel\Gdpr\Portable;
use Laravel\Sanctum\HasApiTokens;
use Webpatser\Countries\Countries;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Soved\Laravel\Gdpr\Contracts\Portable as PortableContract;

class User extends Authenticatable implements PortableContract
{
    use Notifiable;
    use HasRoles;
    use Impersonate;
    use Portable;
    use HasApiTokens;

    protected $gdprWith = ['orders', 'customer', 'reseller', 'provider'];
    protected $gdprHidden = ['password', 'markup'];

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
}
