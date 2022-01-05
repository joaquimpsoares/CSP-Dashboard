<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{

    protected $casts = [
        'payload'   => 'array',
    ];

    public function format()
    {
        return [
            'id'            => $this->id,
            'queue'         => $this->queue,
            'payload'       => $this->getPayload,
            'attempts'      => $this->attempts,
            'reserved_at'   => $this->reserved_at,
            'available_at'  => $this->available_at,
            'created_at'    => $this->created_at,
        ];

    }
}
