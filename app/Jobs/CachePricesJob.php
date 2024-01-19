<?php

namespace App\Jobs;

use App\Events\PriceUpdatedEvent;
use App\Models\StockPrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CachePricesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    public function handle(): void
    {
        $latestPrice = StockPrice::where('symbol', $this->symbol)
            ->latest('date_time')
            ->first();

        if ($latestPrice) {
            Cache::put('stock_price_' . $this->symbol, $latestPrice, now()->addMinutes(1));
        }
    }
}
