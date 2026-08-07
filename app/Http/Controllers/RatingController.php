<?php
// app/Http/Controllers/RatingController.php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'movie_id' => $movie->id],
            ['score' => $request->score]
        );

        $movie->recalculateAverageRating();

        return back()->with('success', 'Terima kasih atas rating kamu!');
    }
}
