@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Dashboard -->
    <div>
        <h2 class="text-2xl font-bold">Dashboard Analitis</h2>
        <p class="text-gray-400 text-sm">Selamat datang kembali, Admin. Berikut ringkasan aktivitas sistem hari ini.</p>
    </div>

    <!-- Grid Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Stat 1: Total Film -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl flex items-center justify-between shadow-lg">
            <div>
                <p class="text-sm text-gray-400 font-medium">Total Koleksi Film</p>
                <h3 class="text-3xl font-bold mt-1 text-indigo-400">142</h3>
            </div>
            <div class="p-3 bg-indigo-600/10 rounded-lg text-indigo-400 text-2xl">🎬</div>
        </div>

        <!-- Stat 2: Total Checkout/Pesanan -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl flex items-center justify-between shadow-lg">
            <div>
                <p class="text-sm text-gray-400 font-medium">Total Gambar Di-checkout</p>
                <h3 class="text-3xl font-bold mt-1 text-emerald-400">1,240</h3>
            </div>
            <div class="p-3 bg-emerald-600/10 rounded-lg text-emerald-400 text-2xl">🛒</div>
        </div>

        <!-- Stat 3: Rata-rata Rating Sistem -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl flex items-center justify-between shadow-lg sm:col-span-2 lg:col-span-1">
            <div>
                <p class="text-sm text-gray-400 font-medium">Rata-rata Rating Global</p>
                <h3 class="text-3xl font-bold mt-1 text-amber-400">⭐ 4.6</h3>
            </div>
            <div class="p-3 bg-amber-600/10 rounded-lg text-amber-400 text-2xl">📈</div>
        </div>
    </div>

    <!-- Aktivitas Pesanan Terbaru (Log Admin) -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-lg">
        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-medium">Log Checkout Terbaru oleh User</h3>
            <span class="text-xs text-indigo-400 font-semibold uppercase tracking-wider">Live Monitor</span>
        </div>
        <div class="p-6 divide-y divide-gray-700/50 space-y-4">
            <!-- Item Log 1 -->
            <div class="flex justify-between items-center pt-4 first:pt-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600/20 text-indigo-400 rounded-full flex items-center justify-center font-bold text-sm">U1</div>
                    <div>
                        <p class="text-sm font-medium text-white">User #041 (Budi)</p>
                        <p class="text-xs text-gray-400">Baru saja meng-checkout cover film <span class="text-indigo-300">"Interstellar"</span></p>
                    </div>
                </div>
                <span class="text-xs text-gray-500">2 menit yang lalu</span>
            </div>
            <!-- Item Log 2 -->
            <div class="flex justify-between items-center pt-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600/20 text-indigo-400 rounded-full flex items-center justify-center font-bold text-sm">U2</div>
                    <div>
                        <p class="text-sm font-medium text-white">User #012 (Siti)</p>
                        <p class="text-xs text-gray-400">Baru saja meng-checkout cover film <span class="text-indigo-300">"Inception"</span></p>
                    </div>
                </div>
                <span class="text-xs text-gray-500">15 menit yang lalu</span>
            </div>
        </div>
    </div>
</div>
@endsection
