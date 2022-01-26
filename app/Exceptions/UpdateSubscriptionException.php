<?php

namespace App\Exceptions;

use Exception;

class UpdateSubscriptionException extends Exception
{
    public function __construct(String $msg = '')
    {
        parent::__construct($msg);
    }
}
