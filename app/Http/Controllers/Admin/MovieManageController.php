<?php
// app/Http/Controllers/Admin/MovieManageController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieManageController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(10);
        return view('admin.manage-movies', compact('movies'));
    }

    public function create()
    {
        return view('admin.movie-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'genre' => ['nullable', 'string', 'max:255'],
            'release_year' => ['nullable', 'digits:4'],
            'duration' => ['nullable', 'string', 'max:50'],
            'certificate' => ['nullable', 'string', 'max:20'],
            'trailer_url' => ['nullable', 'url'],
            'cover_image' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Movie::create($validated);

        return redirect()->route('admin.movies')->with('success', 'Film berhasil ditambahkan.');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movie-form', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'genre' => ['nullable', 'string', 'max:255'],
            'release_year' => ['nullable', 'digits:4'],
            'duration' => ['nullable', 'string', 'max:50'],
            'certificate' => ['nullable', 'string', 'max:20'],
            'trailer_url' => ['nullable', 'url'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover_image')) {
            if ($movie->cover_image) {
                Storage::disk('public')->delete($movie->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $movie->update($validated);

        return redirect()->route('admin.movies')->with('success', 'Film berhasil diperbarui.');
    }

    public function destroy(Movie $movie)
    {
        if ($movie->cover_image) {
            Storage::disk('public')->delete($movie->cover_image);
        }

        $movie->delete();

        return redirect()->route('admin.movies')->with('success', 'Film berhasil dihapus.');
    }
}
