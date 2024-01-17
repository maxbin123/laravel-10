<?php

namespace Database\Factories;

use App\Models\StockPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockPrice>
 */
class StockPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'symbol' => $this->faker->unique()->lexify('????'),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'date_time' => $this->faker->dateTimeThisYear,
        ];
    }
}
