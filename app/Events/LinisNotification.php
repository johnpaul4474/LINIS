<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LinisNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $type;

    public $username;

    public $productName;

    public $productQuantity;

    public $wardName;

    public $officeName;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type,$username,$productName,$productQuantity,$wardName,$officeName)
    {
        $this->type = $type;
        $this->username = $username;       
        $this->productName  = $productName;
        $this->productQuantity  = $productQuantity;
        $this->wardName  = $wardName;
        $this->officeName  = $officeName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['linis-notification'];
    }

    public function broadcastAs()
    {
        return 'linis-event';
    }
}