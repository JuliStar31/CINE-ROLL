<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'status',
    ];

    // Relasi: order milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: order buat satu film
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
