<?php

namespace App;

use App\Status;
use App\PriceList;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use App\Http\Traits\ActivityTrait;
use Webpatser\Countries\Countries;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Provider extends Model implements Searchable
{
    use ActivityTrait;

    protected $fillable = [
        'company_name', 'address_1', 'address_2', 'country_id', 'state', 'city',
        'nif', 'postal_code', 'main_office', 'status_id', 'price_list_id',
        // Stripe billing fields
        'stripe_customer_id', 'stripe_subscription_id', 'stripe_subscription_item_id',
        'stripe_plan', 'stripe_status', 'stripe_currency', 'stripe_interval',
    ];

    protected $searchable = [
        'company_name',
    ];

    public function format()
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'country' => $this->country->name,
            'countrycode' => $this->country->iso_3166_2,
            'city' => $this->city,
            'state' => $this->state,
            'nif' => $this->nif,
            'postal_code' => $this->postal_code,
            'resellers' => $this->resellers,
            'resellersCount' => $this->resellers->count(),
            'customers' => $this->resellers,
            'status' => $this->status->name,
            'created_at' => $this->created_at,
            'path' => $this->path(),
            'mainUser' => $this->users()->first(),
            'instance' => $this->instances()->get(),
        ];
    }

    public $searchableType = 'Provider';

    public function getSearchResult(): SearchResult
    {
       $url = $this->path();
        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->company_name,
           $url
        );
    }

    public function resellers()
    {
        return $this->hasMany(Reseller::class);
    }

    public function getMyCustomersId()
    {
        $customers = [];
        $resellers = $this->resellers()->whereNull('main_office')->get(['id']);
        foreach ($resellers as $reseller) {
            foreach ($reseller->customers()->get(['id']) as $customer) {
                $customers[] = $customer->id;
            }
        }
        return $customers;
    }

    public function path()
    {
        return url("/provider/{$this->id}-" . Str::slug($this->company_name, '-'));
    }

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function instances(){
        return $this->hasMany(Instance::class);
    }

    public function availablePriceLists(){
        return $this->hasMany(PriceList::class);
    }

    public function news(){
        return $this->hasMany(News::class);
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function (Builder $query) {
            $user = Auth::user();
            if ($user && $user->userLevel->name === config('app.super_admin')) {
            }
        });
    }
}
