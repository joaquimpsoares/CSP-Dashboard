<?php

namespace App\Models\Traits;

use App\Scopes\InstanceEnvironmentScope;

trait HasInstanceEnvironment
{
    protected static function bootHasInstanceEnvironment(): void
    {
        static::addGlobalScope(new InstanceEnvironmentScope());

        static::creating(function ($model) {
            if (empty($model->environment)) {
                $model->environment = session('environment', 'live');
            }
            if (empty($model->instance_id) && session()->has('instance_id')) {
                $model->instance_id = session('instance_id');
            }
        });
    }
}
