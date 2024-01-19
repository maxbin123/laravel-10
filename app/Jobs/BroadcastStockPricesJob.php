<?php

namespace App\Jobs;

use App\Events\PriceUpdatedEvent;
use App\Services\StockReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BroadcastStockPricesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    public function handle(StockReportService $service): void
    {
        $report = $service->getReport($this->symbol);
        PriceUpdatedEvent::dispatch($report);
    }
}
