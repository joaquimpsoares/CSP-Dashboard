<?php

namespace App;

use Soved\Laravel\Gdpr\Portable;
use Laravel\Sanctum\HasApiTokens;
use Webpatser\Countries\Countries;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Soved\Laravel\Gdpr\Contracts\Portable as PortableContract;

class User extends Authenticatable implements  JWTSubject, PortableContract
{

    use Notifiable;
    use HasRoles;
    use Impersonate;
    use Portable;
    use HasApiTokens;



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
            'id'      => $this->id,
            'name'      => $this->name,
            'last_name' => $this->last_name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'country'   => $this->country,
            'provider'   => $this->provider,
            'reseller'   => $this->reseller,
            'customer'   => $this->customer,
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


    // protected static function booted(){
    //     static::addGlobalScope('access_level', function(Builder $query){
    //         $user = Auth::user();
    //         // dd($user);
    //         if($user && $user->userLevel->name === config('app.provider')){
    //             $query->whereHas('reseller', function(Builder $query) use($user){
    //                 $query->whereHas('provider', function(Builder $query) use($user){
    //                     $query->where('id', $user->provider->id);
    //                 });
    //             });
    //         }
    //         if($user && $user->userLevel->name === config('app.reseller')){
    //             $query->whereHas('resellers', function(Builder $query) use($user){
    //                 $query->where('id', $user->reseller->id);
    //             });
    //         }
    //     });
    // }
}
