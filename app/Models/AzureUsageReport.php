<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzureUsageReport extends Model
{
    use HasFactory;

    public function prices()
    {
        return $this->hasOne('App\Models\AzurePriceList', 'resource_id', 'resource_id');
    }

    public function subscription()
    {
        return $this->hasOne('App\Models\Subscription','id', 'subscription_id');
    }
}
