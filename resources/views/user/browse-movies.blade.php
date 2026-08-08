@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-4">
    <h1 class="text-2xl font-bold text-white mb-6">Jelajahi Film</h1>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($movies as $movie)
            <a href="{{ route('movie.detail', $movie) }}" class="group">
                <div class="glass-card aspect-[2/3] bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/15 group-hover:border-indigo-400/50">
                    @if($movie->cover_image)
                        <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}"
                            loading="lazy"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500 text-xs">
                            No Cover
                        </div>
                    @endif
                </div>
                <p class="text-sm text-gray-200 mt-2 font-medium truncate transition group-hover:text-indigo-400">
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
