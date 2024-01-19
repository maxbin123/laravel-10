<?php

namespace App\Jobs;

use App\Models\StockPrice;
use App\Services\AlphaVantageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchStockDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    public function handle(AlphaVantageService $alphaVantageService): void
    {
        $stockPrices = $alphaVantageService->fetchStockData($this->symbol);

        if ($stockPrices) {
            StockPrice::upsert($stockPrices, ['symbol', 'date_time'], ['price']);
        }
    }
}
