<?php

namespace App;

use App\Status;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Facades\Log;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;

class Customer extends Model implements Searchable
{

    use ActivityTrait;

    public function format(){
        return [
            'id'            => $this->id,
            'company_name'  => $this->company_name,
            'address_1'     => $this->address_1,
            'address_2'     => $this->address_2,
            'country'       => $this->country->name,
            'city'          => $this->city,
            'state'         => $this->state,
            'nif'           => $this->nif,
            'postal_code'   => $this->postal_code,
            'status'        => $this->status->name,
            'created_at'    => $this->created_at,
            'path'          => $this->path(),
            'mpnid'         => $this->resellers()->first()->mpnid ?? null,
            'tenant_id'     => $this->microsoftTenantInfo->first(),
            'pathUpdate'    => $this->pathUpdate(),
            'reseller'      => $this->resellers()->first(),
            'subscriptions' => $this->subscriptions->count(),
            'priceList'     => $this->priceList,
            'mainUser'      => $this->users()->first(),
            'users'         => $this->users()->get(),
            'azure'         => $this->azure(),
        ];
    }

    public $searchableType = 'Customer';

    public function getSearchResult(): SearchResult
    {
       $url = $this->path();
        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->company_name,
           $url
        );
    }


    const QUALIFICATIONS = [
        '1' => 'Education',
    ];

    public function resellers(){
        return $this->belongsToMany(Reseller::class);
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function azure(){
        return Subscription::where('billing_type', 'usage')->get();
    }

    public function path(){
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-'));
    }

    public function pathEdit(){
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-') . "/edit");
    }

    public function pathUpdate(){
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-') . "/update");
    }

    public function getMyResellersId(){
        $resellersList = [];

        $resellers = $this->resellers()->get(['id']);

        foreach ($resellers as $reseller) {
            $resellersList[] = $reseller->id;
        }

        return $resellersList;
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function microsoftTenantInfo(){
        return $this->hasMany(MicrosoftTenantInfo::class);
    }

    public function microsoftLincenseInfo(){
        return $this->hasMany(microsoftLincenseInfo::class);
    }

    public function updateCustomerQualification($customer, $data){
        $this->instance = $customer->resellers->first()->provider->instances->first();
        $customer = new TagydesCustomer([
            'id' => $customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);

        $resources = MicrosoftCustomer::withCredentials($this->instance->external_id, $this->instance->external_token)->UpdateCustomerQualification($customer, $data);
        // Log::info('Status changed: Suspended');

        return $resources;
    }

    public function checkCustomerQualification($customer){
        $this->instance = $customer->resellers->first()->provider->instances->first();
        $customer = new TagydesCustomer([
            'id' => $customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);

        $resources = MicrosoftCustomer::withCredentials($this->instance->external_id, $this->instance->external_token)->CheckCustomerQualification($customer);

        return $resources;
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function (Builder $query) {
            $user = Auth::user();
            if ($user && $user->userLevel->name === config('app.provider')) {
                $query->whereHas('resellers', function (Builder $query) use ($user) {
                    $query->whereHas('provider', function (Builder $query) use ($user) {
                        $query->where('id', $user->provider->id);
                    });
                });
            }
            if ($user && $user->userLevel->name === config('app.reseller')) {
                $query->whereHas('resellers', function (Builder $query) use ($user) {
                    $query->where('id', $user->reseller->id);
                });
            }
            if ($user && $user->userLevel->name === config('app.customer')) {
                return false;
                // $query->whereHas('resellers', function (Builder $query) use ($user) {
                //     $query->where('id', $user->reseller->id);
                // });
            }
        });
    }
}
