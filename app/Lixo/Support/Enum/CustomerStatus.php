<?php

namespace App\Support\Enum;

class CustomerStatus
{
    const UNCONFIRMED = 'Unconfirmed';
    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';

    public static function lists()
    {
        return [
            self::ACTIVE => trans('app.'.self::ACTIVE),
            self::INACTIVE => trans('app.'. self::INACTIVE),
            self::UNCONFIRMED => trans('app.' . self::UNCONFIRMED)
        ];
    }

}
