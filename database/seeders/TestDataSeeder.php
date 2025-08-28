<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\City;
use App\Models\Cinema;
use App\Models\Studio;
use App\Models\Movie;
use App\Models\Ticket;
use App\Models\Seats;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        $user1 = User::create([
            'name' => 'John Doe',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'gender' => 'male',
            'birthdate' => '1990-01-15',
            'pin' => '123456',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'phone' => '081234567891',
            'email' => 'jane@example.com',
            'gender' => 'female',
            'birthdate' => '1992-05-20',
            'pin' => '654321',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create test city
        $city = City::create([
            'name' => 'Jakarta',
        ]);

        // Create test cinema
        $cinema = Cinema::create([
            'name' => 'CGV Grand Indonesia',
            'address' => 'Jl. MH Thamrin No. 1, Jakarta Pusat',
            'city_id' => $city->id,
        ]);

        // Create test studio
        $studio = Studio::create([
            'name' => 'Studio 1',
            'cinema_id' => $cinema->id,
        ]);

        // Create test movie
        $movie = Movie::create([
            'title' => 'Avengers: Endgame',
            'duration' => 180,
            'age' => 13,
            'animation_type' => '2D',
            'trailer' => 'https://youtube.com/watch?v=example',
            'start_showing' => '2024-01-01',
            'start_selling' => '2023-12-15',
            'synopsis' => 'The epic conclusion to the Infinity Saga.',
            'producer' => 'Marvel Studios',
            'director' => 'Anthony Russo, Joe Russo',
            'writer' => 'Christopher Markus, Stephen McFeely',
            'production' => 'Marvel Studios',
        ]);

        // Create test tickets (schedules)
        $ticket1 = Ticket::create([
            'movie_id' => $movie->id,
            'studio_id' => $studio->id,
            'city_id' => $city->id,
            'cinema_id' => $cinema->id,
            'date' => '2024-12-25',
            'time' => '14:00:00',
            'price' => 50000,
        ]);

        $ticket2 = Ticket::create([
            'movie_id' => $movie->id,
            'studio_id' => $studio->id,
            'city_id' => $city->id,
            'cinema_id' => $cinema->id,
            'date' => '2024-12-25',
            'time' => '17:00:00',
            'price' => 60000,
        ]);

        // Create seats for ticket1 (14:00 show)
        $seatNumbers = ['A1', 'A2', 'A3', 'A4', 'A5', 'B1', 'B2', 'B3', 'B4', 'B5', 'C1', 'C2', 'C3', 'C4', 'C5'];
        
        foreach ($seatNumbers as $seatNumber) {
            Seats::create([
                'ticket_id' => $ticket1->id,
                'number' => $seatNumber,
                'status' => 'available',
            ]);
        }

        // Create seats for ticket2 (17:00 show)
        foreach ($seatNumbers as $seatNumber) {
            Seats::create([
                'ticket_id' => $ticket2->id,
                'number' => $seatNumber,
                'status' => 'available',
            ]);
        }

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Users created: john@example.com, jane@example.com (password: password)');
        $this->command->info('Movie: Avengers: Endgame');
        $this->command->info('Cinema: CGV Grand Indonesia');
        $this->command->info('Tickets: 2024-12-25 14:00 & 17:00');
        $this->command->info('Seats: A1-A5, B1-B5, C1-C5 for each show');
    }
}
