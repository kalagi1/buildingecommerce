<?php

namespace App\Events;

use App\Models\Housing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HousingCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The created housing instance.
     *
     * @var \App\Models\Housing
     */
    public $housing;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Housing  $housing
     * @return void
     */
    public function __construct(Housing $housing)
    {
        $this->housing = $housing;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
