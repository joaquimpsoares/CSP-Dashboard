<?php

namespace App;

use App\Http\Traits\ActivityTrait;
use Webpatser\Countries\Countries;
use Spatie\Permission\Traits\HasRoles;

use App\Services\Auth\Api\TokenFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements  JWTSubject
{
    use Notifiable;
    use HasRoles;
    use Impersonate;
    // use ActivityTrait;

    // protected $guard_name = 'web';

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
            'name' => $this->name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email
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

}
