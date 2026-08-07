@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-white mb-1">Koleksi Film Saya (Checked Out)</h1>
    <p class="text-sm text-gray-400 mb-6">Daftar film yang sudah berhasil kamu checkout.</p>

    @if(session('success'))
        <div class="mb-6 bg-green-600/10 border border-green-500/30 text-green-400 text-sm px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($orders as $order)
            <div class="flex gap-4 bg-gray-800 border border-gray-700 rounded-xl p-4">
                <div class="w-20 h-28 shrink-0 bg-gray-700 rounded-lg overflow-hidden">
                    @if($order->movie->cover_image)
                        <img src="{{ asset('storage/' . $order->movie->cover_image) }}" alt="{{ $order->movie->title }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500 text-xs text-center px-1">
                            [ Cover Film ]
                        </div>
                    @endif
                </div>

                <div class="flex-1 flex flex-col">
                    <div class="flex justify-between items-start">
                        <h2 class="text-lg font-bold text-white">{{ $order->movie->title }}</h2>
                        <span class="text-xs bg-green-600/20 text-green-400 border border-green-500/30 px-2 py-0.5 rounded-full shrink-0">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-400 mt-1 line-clamp-2">
                        {{ $order->movie->description ?? 'Tidak ada sinopsis.' }}
                    </p>

                    <div class="flex justify-between items-end mt-auto pt-3 border-t border-gray-700 text-xs">
                        <span class="text-gray-500">Dipesan: {{ $order->created_at->translatedFormat('d M Y') }}</span>
                        <a href="{{ route('movie.detail', $order->movie) }}" class="text-indigo-400 hover:text-indigo-300 font-semibold">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <p class="text-gray-500">Kamu belum checkout film apa pun.</p>
                <a href="{{ route('user.browse') }}" class="text-indigo-400 hover:text-indigo-300 text-sm mt-2 inline-block">
                    Jelajahi film sekarang →
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
