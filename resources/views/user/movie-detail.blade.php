@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">

    {{-- Notifikasi ajakan login, cuma muncul buat guest --}}
    @guest
        <div x-data="{ show: true }" x-show="show"
            class="mb-6 flex items-center justify-between gap-4 bg-indigo-600/10 border border-indigo-500/30 text-indigo-300 text-sm px-4 py-3 rounded-lg">
            <span>Daftar/login untuk akses lebih lanjut</span>
            <div class="flex items-center gap-3 shrink-0">
                <button @click="$dispatch('open-login')" class="bg-indigo-600 hover:bg-indigo-500 transition text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                    Login
                </button>
                <button @click="show = false" class="text-indigo-300 hover:text-white text-lg leading-none">&times;</button>
            </div>
        </div>
    @endguest

    {{-- Notifikasi sukses checkout --}}
    @if(session('success'))
        <div class="mb-6 bg-green-600/10 border border-green-500/30 text-green-400 text-sm px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

  {{-- Info utama film --}}
<div class="flex flex-col lg:flex-row gap-6">
    <div class="w-full lg:w-56 shrink-0">
        <div class="aspect-[2/3] bg-gray-800 rounded-lg overflow-hidden border border-gray-700">
            @if($movie->cover_image)
                <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}"
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-600 text-xs">No Cover</div>
            @endif
        </div>
    </div>

    <div class="w-full lg:w-72 shrink-0">
        <h1 class="text-3xl font-bold text-white">{{ $movie->title }} @if($movie->release_year) <span class="text-gray-500 font-normal">({{ $movie->release_year }})</span> @endif</h1>

        <p class="text-sm text-gray-400 mt-2">
            @if($movie->certificate) {{ $movie->certificate }} | @endif
            {{ $movie->genre ?? '-' }}
            @if($movie->duration) &middot; {{ $movie->duration }} @endif
        </p>

        <p class="text-sm text-yellow-400 mt-2">⭐ {{ number_format($movie->average_rating, 1) }} / 5</p>

        @if($movie->description)
            <p class="text-gray-300 mt-4 leading-relaxed">{{ $movie->description }}</p>
        @endif

        <div class="flex flex-wrap gap-3 mt-4">
           {{-- Widget Rating --}}
            <div class="mt-6 pt-4 border-t border-gray-700" x-data="{ hover: 0, selected: {{ $userRating ?? 0 }} }">
                <p class="text-sm text-gray-400 mb-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            Admin tidak dapat memberi rating.
                        @else
                            {{ $userRating ? 'Rating kamu:' : 'Beri rating film ini:' }}
                        @endif
                    @else
                        Beri rating film ini:
                    @endauth
                </p>

                @auth
                    @if(!auth()->user()->isAdmin())
                        <form action="{{ route('movie.rate', $movie) }}" method="POST">
                            @csrf
                            <input type="hidden" name="score" :value="selected">
                            <div class="flex gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="submit" @click="selected = {{ $i }}"
                                        @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0"
                                        class="text-2xl leading-none transition"
                                        :class="(hover || selected) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-600'">
                                        ★
                                    </button>
                                @endfor
                            </div>
                        </form>
                    @endif
                @else
                    <div class="flex gap-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" @click="$dispatch('open-login')"
                                class="text-2xl leading-none text-gray-600 hover:text-yellow-400 transition">
                                ★
                            </button>
                        @endfor
                    </div>
                @endauth
            </div>
            @auth
                @if(!auth()->user()->isAdmin())
                    <form action="{{ route('movie.checkout', $movie) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-500 transition text-white text-sm font-semibold px-5 py-2 rounded-lg">
                            🎬 Checkout Film Ini
                        </button>
                    </form>
                @endif
            @else
                <button @click="$dispatch('open-login')"
                    class="bg-green-600 hover:bg-green-500 transition text-white text-sm font-semibold px-5 py-2 rounded-lg">
                    🎬 Checkout Film Ini
                </button>
            @endauth
        </div>
    </div>

    {{-- Video trailer embed --}}
    <div class="flex-1 min-w-0">
        <div class="aspect-video bg-black rounded-lg overflow-hidden border border-gray-700">
            @if($movie->embed_trailer_url)
                <iframe
                    src="{{ $movie->embed_trailer_url }}"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-600 text-sm">
                    Trailer belum tersedia
                </div>
            @endif
        </div>
    </div>
</div>

    {{-- Rekomendasi film lain --}}
    <div class="mt-12">
        <h2 class="text-xl font-bold text-white mb-4">Film Lainnya</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($recommended as $rec)
                <a href="{{ route('movie.detail', $rec) }}" class="group">
                    <div class="aspect-[2/3] bg-gray-800 rounded-lg overflow-hidden border border-gray-700 group-hover:border-indigo-500 transition">
                        @if($rec->cover_image)
                            <img src="{{ asset('storage/' . $rec->cover_image) }}" alt="{{ $rec->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600 text-xs">No Cover</div>
                        @endif
                    </div>
                    <p class="text-sm text-gray-200 mt-2 font-medium truncate group-hover:text-indigo-400">{{ $rec->title }}</p>
                </a>
            @empty
                <p class="col-span-full text-gray-500 text-sm">Belum ada rekomendasi lain.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
