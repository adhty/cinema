<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
         Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade');
            $table->enum('payment', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // Schema::create('order_seat', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
        //     $table->foreignId('seat_id')->constrained('seats')->cascadeOnDelete();
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_seat');
        Schema::dropIfExists('orders');
    }
};
