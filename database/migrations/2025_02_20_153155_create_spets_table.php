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
        Schema::create('spets', function (Blueprint $table) {
            $table->id();
            $table->integer('custom_id');
            $table->bigInteger('user_id');
            $table->year('year'); 
            $table->string('company');
            $table->string('customer');
            $table->decimal('summ', 20, 2);
            $table->json('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spets');
    }
};
