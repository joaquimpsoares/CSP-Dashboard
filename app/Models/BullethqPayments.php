<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BullethqPayments extends Model
{
    use HasFactory;
    protected $casts = [
        'invoiceIds' => 'collection'
    ];
}
