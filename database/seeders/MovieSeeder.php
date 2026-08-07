<?php
// database/seeders/MovieSeeder.php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $movies = [
            ['title' => 'Interstellar', 'genre' => 'Adventure, Drama, Sci-Fi', 'release_year' => 2014, 'duration' => '2h 49m', 'certificate' => 'PG-13', 'average_rating' => 4.8, 'checkout_count' => 320],
            ['title' => 'Inception', 'genre' => 'Action, Sci-Fi, Thriller', 'release_year' => 2010, 'duration' => '2h 28m', 'certificate' => 'PG-13', 'average_rating' => 4.7, 'checkout_count' => 280],
            ['title' => 'The Dark Knight', 'genre' => 'Action, Crime, Drama', 'release_year' => 2008, 'duration' => '2h 32m', 'certificate' => 'PG-13', 'average_rating' => 4.9, 'checkout_count' => 410],
            ['title' => 'Dune', 'genre' => 'Action, Adventure, Drama', 'release_year' => 2021, 'duration' => '2h 35m', 'certificate' => 'PG-13', 'average_rating' => 4.5, 'checkout_count' => 190],
        ];

        foreach ($movies as $movie) {
            Movie::create([
                'title' => $movie['title'],
                'description' => 'Deskripsi singkat untuk film ' . $movie['title'] . '.',
                'cover_image' => null,
                'genre' => $movie['genre'],
                'release_year' => $movie['release_year'],
                'duration' => $movie['duration'],
                'certificate' => $movie['certificate'],
                'trailer_url' => null,
                'average_rating' => $movie['average_rating'],
                'checkout_count' => $movie['checkout_count'],
            ]);
        }
    }
}
