<?php

namespace App\Events\Reseller;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class Created
{
    /**
     * @var Reseller
     */
    protected $createdReseller;

    public function __construct(Reseller $createdReseller)
    {
        $this->createdReseller = $createdReseller;
    }

    /**
     * @return Reseller
     */
    public function getCreatedReseller()
    {
        return $this->createdReseller;
    }
}
