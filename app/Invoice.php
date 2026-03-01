<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'provider_id','reseller_id','customer_id','order_id','number','status','market','currency','issued_at'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function lines()
    {
        return $this->hasMany(InvoiceLine::class, 'invoice_id');
    }
}
