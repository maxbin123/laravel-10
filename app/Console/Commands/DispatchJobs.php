<?php

namespace App\Console\Commands;

use App\Jobs\BroadcastStockPricesJob;
use App\Jobs\CachePricesJob;
use App\Jobs\FetchStockDataJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class DispatchJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Jobs batch to run every minute';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        foreach (config('stocks.symbols') as $symbol) {
            Bus::chain(
                [
                    new FetchStockDataJob($symbol),
                    new CachePricesJob($symbol),
                    new BroadcastStockPricesJob($symbol),
                ]
            )->dispatch();
        }
    }
}
