<?php

namespace App\Models;

use App\Instance;
use App\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MsftInvoices extends Model
{
    use HasFactory;

    public function format()
    {
        return [
            'id'            => $this->id,
            'company_name'  => $this->company_name,
        ];
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('access_level', function (Builder $query) {
            $user = Auth::user();
            if ($user && $user->userLevel->name === config('app.provider')) {
                $query->whereHas('provider', function (Builder $query) use ($user) {
                    $query->where('id', $user->provider->id);
                });
            }
        });
    }
}
