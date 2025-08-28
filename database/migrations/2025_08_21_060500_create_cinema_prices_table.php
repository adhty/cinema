<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cinema_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('studio_id');
            $table->unsignedInteger('friday_price')->default(0);
            $table->unsignedInteger('weekday_price')->default(0);
            $table->unsignedInteger('weekend_price')->default(0);
            $table->timestamps();

            $table->foreign('studio_id')
                ->references('id')
                ->on('studios')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cinema_prices');
    }
};