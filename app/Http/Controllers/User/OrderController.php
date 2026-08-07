<?php
// app/Http/Controllers/User/OrderController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('movie')->latest()->get();
        return view('user.my-orders', compact('orders'));
    }

    public function store(Movie $movie)
    {
        Auth::user()->orders()->create([
            'movie_id' => $movie->id,
            'status' => 'completed',
        ]);

        $movie->increment('checkout_count');

        return redirect()->route('movie.detail', $movie)->with('success', 'Film berhasil di-checkout! Cek di "Pesanan Saya".');
    }
}
