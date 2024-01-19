<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlphaVantageService
{
    const API_FUNCTION = 'TIME_SERIES_INTRADAY';
    const TIME_KEY = 'Time Series (1min)';

    protected $baseUrl = 'https://www.alphavantage.co/query';
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.alpha_vantage.base_url');
        $this->apiKey = config('services.alpha_vantage.api_key');
    }

    public function fetchStockData($symbol, $interval = '1min')
    {
        $response = Http::get($this->baseUrl, [
            'function' => self::API_FUNCTION,
            'symbol' => $symbol,
            'interval' => $interval,
            'apikey' => $this->apiKey
        ]);

        $stockPrices = [];

        if ($response->successful() && isset($response[self::TIME_KEY])) {
            foreach ($response[self::TIME_KEY] as $dateTime => $values) {
                $stockPrices[] = [
                    'symbol' => $symbol,
                    'date_time' => $dateTime,
                    'price' => $values['4. close']
                ];
            }
        } else {
            Log::error('Alpha Vantage API error', ['response' => $response->body()]);
            return null;
        }

        return $stockPrices;
    }
}
