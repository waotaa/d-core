<?php

namespace Vng\DennisCore\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProviderDetachedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Pivot $pivot;

    public function __construct(Pivot $pivot)
    {
        $this->pivot = $pivot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
