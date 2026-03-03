<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class InstanceEnvironmentScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $environment = session('environment', 'live');
        $instanceId  = session('instance_id');

        // Models using this scope MUST have both columns.
        $builder->where($model->getTable() . '.environment', $environment);

        if ($instanceId !== null) {
            $builder->where($model->getTable() . '.instance_id', $instanceId);
        }
    }
}
