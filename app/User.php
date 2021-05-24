<?php

namespace App;

use Soved\Laravel\Gdpr\Portable;
use Webpatser\Countries\Countries;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Soved\Laravel\Gdpr\Contracts\Portable as PortableContract;

class User extends Authenticatable implements  JWTSubject, PortableContract
{

    use Notifiable;
    use HasRoles;
    use Impersonate;
    use Portable;



    /**
     * The attributes that should be visible in the downloadable data.
     *
     * @var array
     */
    // protected $gdprVisible = ['email','name', 'address_1', ];


    protected $gdprWith = ['orders', 'customer','reseller','provider'];

    protected $gdprHidden = ['password','markup'];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function format()
    {
        return [
            'name'      => $this->name,
            'last_name' => $this->last_name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'country'   => $this->country
        ];
    }

    public function country()
    {
    	return $this->belongsTo(Countries::class);
    }

    public function provider() {
        return $this->belongsTo('App\Provider');
    }

    public function reseller() {
         return $this->belongsTo('App\Reseller');
    }

    public function customer() {
        return $this->belongsTo('App\Customer');
   }

    public function userLevel() {
        return $this->belongsTo('App\UserLevel');
    }

    public function orders() {
        return $this->hasMany('App\Order');
    }

    // public function notifications() {
    //     return $this->hasMany('App\NotificationSettings');
    // }

    public function status() {
        return $this->belongsTo('App\Status');
    }

   /**
    * Get the identifier that will be stored in the subject claim of the JWT.
    *
    * @return mixed
    */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
    * Return a key value array, containing any custom claims to be added to the JWT.
    *
    * @return array
    */
    public function getJWTCustomClaims() {
        return [];
    }

    public function news() {
        return $this->hasMany('App\News');
    }
}
