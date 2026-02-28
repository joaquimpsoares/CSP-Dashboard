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
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\CustomerService;

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

    // -------------------------------------------------------------------------
    // Internal helpers
    // -------------------------------------------------------------------------

    /**
     * Resolve a CustomerService scoped to this customer's provider connection.
     * Uses the first instance/provider of the customer's reseller.
     */
    private function getCustomerService(): CustomerService
    {
        $instance   = $this->resellers->first()->provider->instances->first();
        $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
        return new CustomerService($client);
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

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

    // -------------------------------------------------------------------------
    // Partner Center operations
    // -------------------------------------------------------------------------

    /**
     * Update the customer's qualification (e.g. Education) via Partner Center.
     *
     * @param  Customer $customer
     * @param  string   $data  Qualification type
     * @return array           Partner Center response
     */
    public function updateCustomerQualification($customer, $data){
        try {
            $customerService = $this->getCustomerService();
            $tenantId = $customer->microsoftTenantInfo->first()->tenant_id;
            return $customerService->updateQualification($tenantId, $data);
        } catch (\Throwable $th) {
            Log::error('updateCustomerQualification error: ' . $th->getMessage());
            return [];
        }
    }

    /**
     * Check the customer's current qualification status via Partner Center.
     *
     * @param  Customer $customer
     * @return \Illuminate\Support\Collection  Partner Center qualifications as a collection
     */
    public function checkCustomerQualification($customer){
        try {
            $customerService = $this->getCustomerService();
            $tenantId = $customer->microsoftTenantInfo->first()->tenant_id;
            return collect($customerService->getQualifications($tenantId));
        } catch (\Throwable $th) {
            Log::error('checkCustomerQualification error: ' . $th->getMessage());
            return collect([]);
        }
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
            }
        });
    }
}
