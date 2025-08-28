<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Cinema;

class CityCinemasSeeder extends Seeder
{
    public function run()
    {
        $jakarta = City::create(['name' => 'Jakarta']);
        $bogor = City::create(['name' => 'Bogor']);

        Cinema::create(['name' => 'AEON Mall Tanjung Barat XXI', 'city_id' => $jakarta->id]);
        Cinema::create(['name' => 'Agora Mall XXI', 'city_id' => $jakarta->id]);
        Cinema::create(['name' => 'Bogor Trade Mall XXI', 'city_id' => $bogor->id]);
    }
}
   
