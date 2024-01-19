<?php

namespace App\Http\Controllers;

use App\Models\StockPrice;
use Illuminate\Support\Facades\Cache;

class StockPriceController extends Controller
{
    public function __invoke($symbol)
    {
        $cache = Cache::get('stock_price_' . $symbol);

        return $cache ?: StockPrice::where('symbol', '=', $symbol)
            ->latest('date_time')
            ->firstOrFail();
    }
}
