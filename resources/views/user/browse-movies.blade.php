@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-white mb-6">Jelajahi Film</h1>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($movies as $movie)
            <a href="{{ route('movie.detail', $movie) }}" class="group">
                <div class="aspect-[2/3] bg-gray-800 rounded-lg overflow-hidden border border-gray-700 group-hover:border-indigo-500 transition">
                    @if($movie->cover_image)
                        <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600 text-xs">
                            No Cover
                        </div>
                    @endif
                </div>
                <p class="text-sm text-gray-200 mt-2 font-medium truncate group-hover:text-indigo-400">
                    {{ $movie->title }}
                </p>
                @if($movie->release_year)
                    <p class="text-xs text-gray-500">{{ $movie->release_year }}</p>
                @endif
            </a>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">Belum ada film yang tersedia.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $movies->links() }}
    </div>
</div>
@endsection
