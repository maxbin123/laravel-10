<?php

namespace App\Services;

use App\Models\StockPrice;

class StockReportService
{

    public function getReport(string $symbol)
    {
        $latestPrices = StockPrice::where('symbol', $symbol)
            ->latest('date_time')
            ->limit(2)
            ->get();

        $latest = $latestPrices[0];

        if (count($latestPrices) === 2) {
            $latest->change = round($latestPrices[0]['price'] - $latestPrices[1]['price'], 2);
        }

        return $latest;
    }
}
