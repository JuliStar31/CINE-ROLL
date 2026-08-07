@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Kelola Film</h1>
        <a href="{{ route('admin.movies.create') }}"
            class="bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold px-4 py-2 rounded-lg">
            + Tambah Film
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-600/10 border border-green-500/30 text-green-400 text-sm px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-900 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Cover</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Genre</th>
                    <th class="px-4 py-3">Rating</th>
                    <th class="px-4 py-3">Checkout</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($movies as $movie)
                    <tr class="text-gray-200">
                        <td class="px-4 py-3">
                            @if($movie->cover_image)
                                <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->title }}"
                                    class="w-10 h-14 object-cover rounded">
                            @else
                                <div class="w-10 h-14 bg-gray-700 rounded flex items-center justify-center text-xs text-gray-500">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $movie->title }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $movie->genre ?? '-' }}</td>
                        <td class="px-4 py-3">⭐ {{ number_format($movie->average_rating, 1) }}</td>
                        <td class="px-4 py-3">{{ $movie->checkout_count }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.movies.edit', $movie) }}"
                                class="text-indigo-400 hover:text-indigo-300 text-sm">Edit</a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin mau hapus film ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada film.</td>
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
