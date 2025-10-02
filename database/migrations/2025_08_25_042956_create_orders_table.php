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
            // database/migrations/xxxx_xx_xx_create_orders_table.php
            Schema::create('orders', function (Blueprint $table) {
                $table->id();

                // User
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

                // Seat
                $table->unsignedBigInteger('seat_id');
                $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');

                // Payment status
                $table->enum('payment', ['pending', 'paid', 'cancelled'])->default('pending');

                $table->timestamps();
            });


            // Pivot untuk kursi yang dibooking
            Schema::create('order_seat', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('seat_id');
                $table->timestamps();

                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('orders');
        }
    };
