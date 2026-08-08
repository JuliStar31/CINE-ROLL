@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Kelola Film</h1>
        <a href="{{ route('admin.movies.create') }}"
            class="btn-liquid flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-lg shadow-indigo-600/30">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5v14"/>
            </svg>
            Tambah Film
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-500/10 backdrop-blur-xl border border-green-400/25 text-green-300 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white/10 backdrop-blur-xl border border-white/15 rounded-2xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-white/5 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Cover</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Genre</th>
                    <th class="px-4 py-3">Rating</th>
                    <th class="px-4 py-3">Checkout</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($movies as $movie)
                    <tr class="text-gray-200 transition hover:bg-white/5">
                        <td class="px-4 py-3">
                            @if($movie->cover_image)
                                <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}"
                                    class="w-10 h-14 object-cover rounded-lg border border-white/10">
                            @else
                                <div class="w-10 h-14 bg-white/5 border border-white/10 rounded-lg flex items-center justify-center text-xs text-gray-500">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $movie->title }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $movie->genre ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="flex items-center gap-1 text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/>
                                </svg>
                                {{ number_format($movie->average_rating, 1) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $movie->checkout_count }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('admin.movies.edit', $movie) }}"
                                class="text-indigo-400 hover:text-indigo-300 text-sm transition">Edit</a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin mau hapus film ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-500">Belum ada film.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $movies->links() }}
    </div>
</div>
@endsection
