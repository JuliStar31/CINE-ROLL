<?php
// database/seeders/OrderSeeder.php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $budi = User::where('email', 'budi@example.com')->first();
        $siti = User::where('email', 'siti@example.com')->first();

        $interstellar = Movie::where('title', 'Interstellar')->first();
        $inception = Movie::where('title', 'Inception')->first();

        Order::create([
            'user_id' => $budi->id,
            'movie_id' => $interstellar->id,
            'status' => 'completed',
        ]);

        Order::create([
            'user_id' => $siti->id,
            'movie_id' => $inception->id,
            'status' => 'completed',
        ]);
    }
}
