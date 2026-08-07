<?php
// app/Http/Controllers/User/BrowseMovieController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrowseMovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(18);

        return view('user.browse-movies', compact('movies'));
    }

    public function show(Movie $movie)
    {
        $recommended = Movie::where('id', '!=', $movie->id)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $userRating = null;
        if (Auth::check() && !Auth::user()->isAdmin()) {
            $userRating = $movie->ratings()->where('user_id', Auth::id())->value('score');
        }

        return view('user.movie-detail', compact('movie', 'recommended', 'userRating'));
    }
}
