<?php

namespace App\Exports;

use App\Subscription;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscriptionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array{
        return [
            '#',
            'name',
            'subscription id',
            'amount',
            'product id',
            'expiration date',
            'billing type',
            'billing Period',
            'msrpid',
            'term',
            'tenant_name',
            'Customer'
        ];
    }

    protected $subscriptions;

    public function __construct($subscriptions){

        $subscriptions->map(function ($subscriptions) {
            if (true) {
                $subscriptions->pluck('id')->toArray();
            }
        });
        dd($subscriptions->items());
        dd($subscriptions->hasMorePages());
        $this->subscriptions = $subscriptions;
    }

    public function map($subscriptions): array{
        return [
            $subscriptions->id,
            $subscriptions->name,
            $subscriptions->subscription_id,
            $subscriptions->amount,
            $subscriptions->product_id,
            $subscriptions->expiration_data,
            $subscriptions->billing_type,
            $subscriptions->billing_period,
            $subscriptions->msrpid,
            $subscriptions->term,
            $subscriptions->tenant_name,
        ];
    }


    public function query(){
        $tt =  Subscription::query()->whereKey($this->subscriptions)->get();
        dd($tt);
    }
}
