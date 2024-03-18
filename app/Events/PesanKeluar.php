<?php

namespace App\Events;

use App\Models\KotakPesan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesanKeluar implements ShouldBroadcast
{ 
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $kotakPesan;
    public $fakultas_id;
    public function __construct($kotakPesan)
    {
       $this->kotakPesan = $kotakPesan;
    
    }

    public function broadcastWith()
    {
         //echo"broadcastWith";
        return  ['data'=>$this->kotakPesan];
    }
    public function broadcastOn()
    {
        return new PrivateChannel('kotak-masuk.'.$this->kotakPesan->fakultas_id);
     
    }
}
