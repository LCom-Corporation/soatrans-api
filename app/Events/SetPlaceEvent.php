<?php

namespace App\Events;

use App\Models\Offre;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SetPlaceEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Offre $offre;
    /**
     * Create a new event instance.
     */
    public function __construct(public int $id, public $places_ocupees)
    {
        $this->offre = Offre::find($id);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('setPlace.' . $this->offre->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'placing';
    }
}
