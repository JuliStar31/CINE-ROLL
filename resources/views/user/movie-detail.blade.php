@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-4">

    {{-- Notifikasi ajakan login, cuma muncul buat guest --}}
    @guest
        <div x-data="{ show: true }" x-show="show"
            class="mb-6 flex items-center justify-between gap-4 bg-indigo-500/10 backdrop-blur-xl border border-indigo-400/25 text-indigo-300 text-sm px-4 py-3 rounded-xl">
            <span>Daftar/login untuk akses lebih lanjut</span>
            <div class="flex items-center gap-3 shrink-0">
                <button @click="$dispatch('open-login')" class="btn-liquid bg-indigo-600 hover:bg-indigo-500 transition text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                    Login
                </button>
                <button @click="show = false" class="text-indigo-300 hover:text-white text-lg leading-none transition">&times;</button>
            </div>
        </div>
    @endguest

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="mb-6 bg-green-500/10 backdrop-blur-xl border border-green-400/25 text-green-300 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Info utama film --}}
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-56 shrink-0">
            <div class="glass-card aspect-[2/3] bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/15">
                @if($movie->cover_image)
                    <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-500 text-xs">No Cover</div>
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

            <p class="text-sm text-yellow-400 mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/>
                </svg>
                {{ number_format($movie->average_rating, 1) }} / 5
            </p>

            @if($movie->description)
                <p class="text-gray-300 mt-4 leading-relaxed">{{ $movie->description }}</p>
            @endif

            <div class="flex flex-wrap gap-3 mt-4">
                @auth
                    @if(!auth()->user()->isAdmin())
                        <form action="{{ route('movie.checkout', $movie) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn-liquid flex items-center gap-2 bg-green-600 hover:bg-green-500 transition text-white text-sm font-semibold px-5 py-2 rounded-lg shadow-lg shadow-green-600/30">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 3v18M17 3v18M3 7.5h4M17 7.5h4M3 12h18M3 16.5h4M17 16.5h4"/>
                                </svg>
                                Checkout Film Ini
                            </button>
                        </form>
                    @endif
                @else
                    <button @click="$dispatch('open-login')"
                        class="btn-liquid flex items-center gap-2 bg-green-600 hover:bg-green-500 transition text-white text-sm font-semibold px-5 py-2 rounded-lg shadow-lg shadow-green-600/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 3v18M17 3v18M3 7.5h4M17 7.5h4M3 12h18M3 16.5h4M17 16.5h4"/>
                        </svg>
                        Checkout Film Ini
                    </button>
                @endauth
            </div>

            {{-- Widget Rating --}}
            <div class="mt-6 pt-4 border-t border-white/10" x-data="{ hover: 0, selected: {{ $userRating ?? 0 }} }">
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
                                        class="transition hover:scale-110"
                                        :class="(hover || selected) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-600'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </form>
                    @endif
                @else
                    <div class="flex gap-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" @click="$dispatch('open-login')"
                                class="text-gray-600 hover:text-yellow-400 transition hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                @endauth
            </div>
        </div>

        {{-- Video trailer embed --}}
        <div class="flex-1 min-w-0">
            <div class="glass-card aspect-video bg-black/40 backdrop-blur-xl rounded-xl overflow-hidden border border-white/15">
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
                    <div class="glass-card aspect-[2/3] bg-white/10 backdrop-blur-xl rounded-xl overflow-hidden border border-white/15 group-hover:border-indigo-400/50">
                        @if($rec->cover_image)
                            <img src="{{ asset('storage/' . $rec->cover_image) }}" alt="{{ $rec->title }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500 text-xs">No Cover</div>
                        @endif
                    </div>
                    <p class="text-sm text-gray-200 mt-2 font-medium truncate transition group-hover:text-indigo-400">{{ $rec->title }}</p>
                </a>
            @empty
                <p class="col-span-full text-gray-500 text-sm">Belum ada rekomendasi lain.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
