<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzurePriceList extends Model
{
    use HasFactory;

    protected $casts = [
        'rates' => 'array'
    ];
}
