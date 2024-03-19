<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KirimNotifikasi implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $penerima_id;
    public function __construct($penerima_id)
    {
        $this->penerima_id = $penerima_id;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('kirim-notif.' . $this->penerima_id);
    }
}
