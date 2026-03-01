<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionScheduledChange extends Model
{
    protected $table = 'subscription_scheduled_changes';

    protected $fillable = [
        'subscription_id',
        'provider_id',
        'customer_id',
        'pc_subscription_id',
        'type',
        'payload',
        'status',
        'effective_date',
        'requested_by_user_id',
        'requested_by_email',
        'policy_decision',
        'api_response',
    ];

    protected $casts = [
        'payload' => 'array',
        'policy_decision' => 'array',
        'api_response' => 'array',
        'effective_date' => 'datetime',
    ];
}
