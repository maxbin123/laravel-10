<?php

namespace Tests\Feature;

use App\Models\StockPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class StockPriceEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_stock_price_endpoint_no_cache(): void
    {
        $stock = StockPrice::factory()->create();

        $response = $this->get('/price/' . $stock->symbol);

        $response->assertStatus(200);
    }

    public function test_stock_price_endpoint_not_found(): void
    {
        StockPrice::factory()->create();

        $response = $this->get('/price/AAAAA');

        $response->assertStatus(404);
    }

    public function test_stock_price_endpoint_cache(): void
    {
        $stock = StockPrice::factory()->create();
        Cache::shouldReceive('get')
            ->once()
            ->with('stock_price_' . $stock->symbol)
            ->andReturn(null);

        $response = $this->get('/price/' . $stock->symbol);

        $response->assertStatus(200);
    }
}
