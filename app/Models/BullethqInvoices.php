<?php

namespace App\Models;

use App\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BullethqInvoices extends Model
{
    use HasFactory;
    protected $casts = [
        'invoiceLines' => 'collection'
    ];

    // protected static function booted(){
    //     static::addGlobalScope('access_level', function(Builder $query){

    // }
}
