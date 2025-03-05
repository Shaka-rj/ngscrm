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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->decimal('main_price', 10, 2); //0.00-10^10.00
            $table->integer('main_percent');
            $table->decimal('price', 10, 2);
            $table->integer('vat_percent');
            $table->decimal('price_after_vat', 10, 2);
            $table->decimal('main_price2', 10, 2); //0.00-10^10.00
            $table->integer('main_percent2');
            $table->decimal('price2', 10, 2);
            $table->integer('vat_percent2');
            $table->decimal('price_after_vat2', 10, 2);
            $table->string('expired_data');
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
