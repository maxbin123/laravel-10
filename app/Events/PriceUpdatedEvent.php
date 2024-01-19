<?php

namespace App\Events;

use App\Models\StockPrice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PriceUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public StockPrice $price;

    public function __construct(StockPrice $price)
    {
        $this->price = $price;
    }

    public function broadcastAs(): string
    {
        return 'updated';
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('price-updates')
        ];
    }
}
