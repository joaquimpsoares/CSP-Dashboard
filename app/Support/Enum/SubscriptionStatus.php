<?php

namespace App\Support\Enum;

class SubscriptionStatus
{
    const ACTIVE = 'Active';
    const DISABLED = 'Disabled';

    public static function lists()
    {
        return [
            self::ACTIVE => trans('app.'.self::ACTIVE),
            self::INACTIVE => trans('app.'. self::DISABLED),
¡        ];
    }

}
