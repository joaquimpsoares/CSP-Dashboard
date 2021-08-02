<?php

namespace App;

use App\Status;
use Illuminate\Support\Str;
use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Model
{
    use ActivityTrait;

    public function format()
    {
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
            'mpnid'         => $this->resellers()->first()->mpnid,
            'tenant_id'     => $this->microsoftTenantInfo->first(),
            'pathUpdate'    => $this->pathUpdate(),
            'reseller'      => $this->resellers()->first(),
            'subscriptions' => $this->subscriptions->count(),
            'priceLists'    => $this->priceLists()->first(),
            'mainUser'      => $this->users()->first(),
            'users'         => $this->users()->get(),
            'azure'         => $this->azure(),
        ];
    }

    public function resellers()
    {
        return $this->belongsToMany(Reseller::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function priceLists()
    {
        return $this->hasMany(PriceList::class, 'id', 'price_list_id');
    }

    public function azure()
    {
        return Subscription::where('billing_type', 'usage')->paginate('10');
    }

    public function path()
    {
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-'));
    }

    public function pathEdit()
    {
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-') . "/edit");
    }

    public function pathUpdate()
    {
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-') . "/update");
    }

    public function getMyResellersId()
    {
        $resellersList = [];

        $resellers = $this->resellers()->get(['id']);

        foreach ($resellers as $reseller) {
            $resellersList[] = $reseller->id;
        }

        return $resellersList;
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function microsoftTenantInfo()
    {
        return $this->hasMany(MicrosoftTenantInfo::class);
    }

    public function microsoftLincenseInfo()
    {
        return $this->hasMany(microsoftLincenseInfo::class);
    }

    protected static function booted()
    {
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
        });
    }
}
