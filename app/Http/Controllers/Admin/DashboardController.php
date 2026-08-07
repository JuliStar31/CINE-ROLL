<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMovies = Movie::count();
        $totalCheckouts = Order::count();
        $averageRating = Movie::avg('average_rating');

        $recentOrders = Order::with(['user', 'movie'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMovies',
            'totalCheckouts',
            'averageRating',
            'recentOrders'
        ));
    }
}
