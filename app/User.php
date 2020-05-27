<?php

namespace App;

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

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'username', 'email', 'password', 'status', 'provider_id', 'reseller_id', 'user_level_id', 'notify', 'notified'
    ];

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
            'first_name' => $this->first_name,
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
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
    * Return a key value array, containing any custom claims to be added to the JWT.
    *
    * @return array
    */
    public function getJWTCustomClaims()
    {
        $token = app(TokenFactory::class)->forUser($this);

        return [
            'jti' => $token->id
        ];
    }

}
