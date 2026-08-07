@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-white mb-6">
        {{ isset($movie) ? 'Edit Film' : 'Tambah Film Baru' }}
    </h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-600/10 border border-red-500/30 text-red-400 text-sm px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ isset($movie) ? route('admin.movies.update', $movie) : route('admin.movies.store') }}"
          enctype="multipart/form-data"
          class="space-y-5 bg-gray-800 border border-gray-700 rounded-xl p-6">
        @csrf
        @if(isset($movie))
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm text-gray-400 mb-1">Judul Film</label>
            <input type="text" name="title" value="{{ old('title', $movie->title ?? '') }}" required
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Sinopsis</label>
            <textarea name="description" rows="4"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">{{ old('description', $movie->description ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Genre</label>
                <input type="text" name="genre" placeholder="Action, Drama, Thriller"
                    value="{{ old('genre', $movie->genre ?? '') }}"
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Tahun Rilis</label>
                <input type="number" name="release_year" placeholder="2026"
                    value="{{ old('release_year', $movie->release_year ?? '') }}"
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Durasi</label>
                <input type="text" name="duration" placeholder="2h 5m"
                    value="{{ old('duration', $movie->duration ?? '') }}"
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Sertifikat</label>
                <input type="text" name="certificate" placeholder="R, PG-13"
                    value="{{ old('certificate', $movie->certificate ?? '') }}"
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Link Trailer (YouTube, dll)</label>
            <input type="url" name="trailer_url" placeholder="https://youtube.com/watch?v=..."
                value="{{ old('trailer_url', $movie->trailer_url ?? '') }}"
                class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Cover Film</label>

            @if(isset($movie) && $movie->cover_image)
                <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}"
                    class="w-24 h-36 object-cover rounded-lg mb-2 border border-gray-700">
            @endif

            <input type="file" name="cover_image" accept="image/*"
                class="w-full text-sm text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:text-white file:text-sm hover:file:bg-indigo-500">
            <p class="text-xs text-gray-500 mt-1">Format JPG/PNG, maksimal 2MB.</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold px-5 py-2 rounded-lg">
                {{ isset($movie) ? 'Simpan Perubahan' : 'Tambah Film' }}
            </button>
            <a href="{{ route('admin.movies') }}"
                class="bg-gray-700 hover:bg-gray-600 transition text-gray-200 text-sm font-semibold px-5 py-2 rounded-lg">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
