@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-4">
    <h1 class="text-2xl font-bold text-white mb-1">Dashboard Admin</h1>
    <p class="text-sm text-gray-400 mb-8">Ringkasan aktivitas Movierate saat ini.</p>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card bg-white/10 backdrop-blur-xl border border-white/15 rounded-2xl p-6">
            <p class="text-sm text-gray-400">Total Film</p>
            <p class="text-3xl font-bold text-white mt-1">{{ $totalMovies }}</p>
        </div>

        <div class="glass-card bg-white/10 backdrop-blur-xl border border-white/15 rounded-2xl p-6">
            <p class="text-sm text-gray-400">Total Checkout</p>
            <p class="text-3xl font-bold text-white mt-1">{{ $totalCheckouts }}</p>
        </div>

        <div class="glass-card bg-white/10 backdrop-blur-xl border border-white/15 rounded-2xl p-6">
            <p class="text-sm text-gray-400">Rata-rata Rating</p>
            <p class="text-3xl font-bold text-white mt-1">
                ⭐ {{ number_format($averageRating ?? 0, 1) }}
            </p>
        </div>
    </div>

    {{-- Log order terbaru --}}
    <div class="bg-white/10 backdrop-blur-xl border border-white/15 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10">
            <h2 class="text-lg font-bold text-white">Checkout Terbaru</h2>
        </div>

        <div class="divide-y divide-white/10">
            @forelse($recentOrders as $order)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-600/30 border border-indigo-400/30 flex items-center justify-center text-xs font-bold text-indigo-300">
                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm text-white">
                                <span class="font-semibold">{{ $order->user->name }}</span>
                                checkout
                                <span class="font-semibold">{{ $order->movie->title }}</span>
                            </p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="text-xs bg-green-500/15 text-green-400 border border-green-500/25 px-2.5 py-1 rounded-full">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-gray-500 text-sm">
                    Belum ada aktivitas checkout.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
