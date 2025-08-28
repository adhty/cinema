<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seats;
use App\Models\Order;

class SampleOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $john = User::where('email', 'john@example.com')->first();
        $jane = User::where('email', 'jane@example.com')->first();

        if (!$john || !$jane) {
            $this->command->error('Users not found! Please run TestDataSeeder first.');
            return;
        }

        // Get available seats (seats without orders)
        $seats = Seats::whereDoesntHave('order')->take(5)->get();

        if ($seats->count() < 4) {
            $this->command->error('Not enough available seats found! Please run TestDataSeeder first.');
            return;
        }

        // Create sample orders
        $orders = [
            [
                'user' => $john,
                'seat' => $seats[0], // A1
                'payment' => 'paid'
            ],
            [
                'user' => $john,
                'seat' => $seats[1], // A2
                'payment' => 'pending'
            ],
            [
                'user' => $jane,
                'seat' => $seats[2], // A3
                'payment' => 'paid'
            ],
            [
                'user' => $jane,
                'seat' => $seats[3], // A4
                'payment' => 'pending'
            ],
        ];

        foreach ($orders as $orderData) {
            // Create order
            $order = Order::create([
                'user_id' => $orderData['user']->id,
                'seat_id' => $orderData['seat']->id,
                'payment' => $orderData['payment']
            ]);

            // Mark seat as booked
            $orderData['seat']->markAsBooked();

            $this->command->info("Order created: {$orderData['user']->name} booked seat {$orderData['seat']->number} - {$orderData['payment']}");
        }

        $this->command->info('Sample orders created successfully!');
        $this->command->info('John has 2 orders (1 paid, 1 pending)');
        $this->command->info('Jane has 2 orders (1 paid, 1 pending)');
    }
}
