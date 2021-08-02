<?php

namespace App;

use App\Status;
use Illuminate\Support\Str;
use App\Http\Traits\ActivityTrait;
use Webpatser\Countries\Countries;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\PriceList;

class Provider extends Model
{
    use ActivityTrait;

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

    public function instances()
    {
        return $this->hasMany(Instance::class);
    }

    public function priceList()
    {
        return $this->belongsTo(PriceList::class);
    }

    public function availablePriceLists()
    {
        return $this->hasMany(PriceList::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('access_level', function (Builder $query) {
            $user = Auth::user();
            if ($user && $user->userLevel->name === config('app.super_admin')) {
            }
        });
    }
}
