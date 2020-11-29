<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ProviderScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if(session()->has('provider_id')){
            $builder->where('provider_id', session()->get('provider_id'));
        }
        if(session()->has('reseller_id')){
            $builder->where('reseller_id', session()->get('reseller_id'));
        }
        if(session()->has('customer_id')){
            $builder->where('customer_id', session()->get('customer_id'));
        }
    }
}
