<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobProgressUpdated
{
    use Dispatchable, SerializesModels;

    public $percentage;

    /**
     * Create a new event instance.
     *
     * @param  int  $percentage
     * @return void
     */
    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }
}
