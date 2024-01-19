<?php

namespace Tests\Feature;

use App\Jobs\FetchStockDataJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FetchStockDataJobTest extends TestCase
{

    use RefreshDatabase;

    public function testFetchStockDataJob()
    {
        Http::fake([
            'www.alphavantage.co/query*' => Http::response(
                [
                    "Meta Data" => [
                        "1. Information" => "Intraday (1min) open, high, low, close prices and volume",
                        "2. Symbol" => "AAPL",
                        "3. Last Refreshed" => "2024-01-16 19:59:00",
                        "4. Interval" => "1min",
                        "5. Output Size" => "Compact",
                        "6. Time Zone" => "US/Eastern",
                    ],
                    "Time Series (1min)" => [
                        "2024-01-16 19:59:00" => [
                            "1. open" => "183.0800",
                            "2. high" => "183.1400",
                            "3. low" => "183.0400",
                            "4. close" => "183.0600",
                            "5. volume" => "908",
                        ],
                        "2024-01-16 19:58:00" => [
                            "1. open" => "183.0250",
                            "2. high" => "183.0900",
                            "3. low" => "183.0250",
                            "4. close" => "183.0800",
                            "5. volume" => "421",
                        ],
                        "2024-01-16 19:57:00" => [
                            "1. open" => "183.0300",
                            "2. high" => "183.0400",
                            "3. low" => "183.0100",
                            "4. close" => "183.0400",
                            "5. volume" => "958",
                        ]]], 200)
        ]);

        FetchStockDataJob::dispatch('AAPL');

        $this->assertDatabaseHas('stock_prices', [
            'symbol' => 'AAPL',
            'date_time' => '2024-01-16 19:59:00',
            'price' => '183.0600'
        ]);
    }
}

