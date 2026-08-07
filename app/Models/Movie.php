<?php
// app/Models/Movie.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'genre',
        'release_year',
        'duration',
        'certificate',
        'trailer_url',
        'average_rating',
        'checkout_count',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function recalculateAverageRating(): void
    {
        $this->update([
            'average_rating' => $this->ratings()->avg('score') ?? 0,
        ]);
    }

    public function getEmbedTrailerUrlAttribute(): ?string
    {
        if (! $this->trailer_url) {
            return null;
        }

        if (preg_match('/[?&]v=([^&]+)/', $this->trailer_url, $match)) {
            $videoId = $match[1];
        } elseif (preg_match('/youtu\.be\/([^?&]+)/', $this->trailer_url, $match)) {
            $videoId = $match[1];
        } else {
            return null;
        }

        return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&rel=0";
    }
}
