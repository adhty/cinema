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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('duration');
            $table->integer('age');
            $table->string('animation_type')->nullable();
            $table->string('trailer')->nullable();
            $table->date('start_showing')->nullable();
            $table->date('start_selling')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('producer')->nullable();
            $table->string('director')->nullable();
            $table->string('writer')->nullable();
            $table->string('production')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
