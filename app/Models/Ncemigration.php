<?php

namespace App\Models;

use App\Order;
use App\OrderProducts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ncemigration extends Model
{
    use HasFactory;

    public function orders(){
        return $this->hasMany(Order::class, 'subscription_id', 'subscription_id');
    }


}
