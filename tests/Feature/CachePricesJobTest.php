<?php

namespace Tests\Feature;

use App\Jobs\CachePricesJob;
use App\Models\StockPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CachePricesJobTest extends TestCase
{
    use RefreshDatabase;

    public function testCachePricesJobCachesLatestPrice()
    {
        $symbol = 'AAPL';
        $stockPrice = StockPrice::create([
            'symbol' => $symbol,
            'price' => 150.50,
            'date_time' => now()
        ]);
        $this->assertFalse(Cache::has('stock_price_' . $symbol));

        $job = new CachePricesJob($symbol);
        dispatch($job);

        $cachedPrice = Cache::get('stock_price_' . $symbol);
        $this->assertEquals($stockPrice->toArray(), $cachedPrice->toArray());
    }
}
