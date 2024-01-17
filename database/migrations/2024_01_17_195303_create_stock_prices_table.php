<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_prices', function (Blueprint $table) {
            $table->id();

            $table->string('symbol', 8);
            $table->decimal('price', 10, 2);
            $table->dateTime('date_time');

            $table->unique(['symbol', 'date_time']);
            $table->index(['symbol']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_prices');
    }
};
