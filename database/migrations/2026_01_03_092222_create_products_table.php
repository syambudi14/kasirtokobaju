<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('category'); // Kemeja, Kaos, Celana, Aksesoris
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            // Stock per size
            $table->integer('stock_s')->default(0);
            $table->integer('stock_m')->default(0);
            $table->integer('stock_l')->default(0);
            $table->integer('stock_xl')->default(0);
            $table->integer('stock_xxl')->default(0);

            // Computed total stock can be done in model accesors, but storing it for quick query is fine too
            $table->integer('total_stock')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
