<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movierate - Laravel UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-900 text-gray-100 font-sans"
      x-data="{ loginOpen: {{ $errors->any() ? 'true' : 'false' }}, logoutOpen: false, showPassword: false }"
      @open-login.window="loginOpen = true">

    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-gray-700 px-6 py-4 flex items-center gap-6">
        <a href="{{ route('user.browse') }}" class="text-xl font-bold text-indigo-500 tracking-wider shrink-0">
            MOVIERATE
        </a>

        <form action="{{ route('user.browse') }}" method="GET" class="flex-1 max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari film..."
                class="w-full bg-gray-900 border border-gray-700 rounded-full px-4 py-1.5 text-sm text-white focus:outline-none focus:border-indigo-500">
        </form>

        <div class="hidden md:flex items-center gap-5 text-sm">
            <a href="{{ route('user.browse') }}" class="text-gray-300 hover:text-indigo-400 transition">Beranda</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-indigo-400 transition">Dashboard</a>
                    <a href="{{ route('admin.movies') }}" class="text-gray-300 hover:text-indigo-400 transition">Kelola Film</a>
                @else
                    <a href="{{ route('user.orders') }}" class="text-gray-300 hover:text-indigo-400 transition">Pesanan Saya</a>
                @endif
            @endauth
        </div>

        <div class="flex items-center gap-4 ml-auto shrink-0">
            @auth
                <span class="text-sm text-gray-400 hidden sm:inline">
                    {{ auth()->user()->name }}
                    <span class="text-xs text-indigo-400 uppercase">({{ auth()->user()->role }})</span>
                </span>
                <button @click="logoutOpen = true"
                    class="text-sm bg-gray-700 hover:bg-gray-600 transition px-3 py-1 rounded-full">
                    Logout
                </button>
            @else
                <button @click="loginOpen = true"
                    class="text-sm bg-indigo-600 hover:bg-indigo-500 transition px-4 py-1.5 rounded-full font-semibold">
                    Login
                </button>
            @endauth
        </div>
    </nav>

    <!-- Wrapper Konten -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </div>

    <!-- Modal Login -->
    <div x-show="loginOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm bg-black/50"
        @click.self="loginOpen = false">

        <div class="w-full max-w-sm bg-gray-800 border border-gray-700 rounded-xl p-8 shadow-lg relative">
            <button @click="loginOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl leading-none">&times;</button>

            <div class="text-center mb-6">
                <div class="text-xl font-bold text-indigo-500 tracking-wider">MOVIERATE</div>
                <p class="text-sm text-gray-400 mt-1">Masuk ke akun kamu</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-600/10 border border-red-500/30 text-red-400 text-sm px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 pr-10 text-sm focus:outline-none focus:border-indigo-500">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white text-xs">
                            <span x-show="!showPassword">Show</span>
                            <span x-show="showPassword" x-cloak>Hide</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded bg-gray-900 border-gray-700">
                    <label for="remember" class="text-sm text-gray-400">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold py-2 rounded-lg">
                    Masuk
                </button>

                <p class="text-center text-xs text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300">Daftar</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div x-show="logoutOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm bg-black/50"
        @click.self="logoutOpen = false">

        <div class="w-full max-w-sm bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg text-center">
            <p class="text-white font-medium mb-1">Yakin mau logout?</p>
            <p class="text-sm text-gray-400 mb-6">Kamu perlu login lagi buat akses fitur ini.</p>

            <div class="flex justify-center gap-3">
                <button @click="logoutOpen = false"
                    class="bg-gray-700 hover:bg-gray-600 transition text-gray-200 text-sm font-semibold px-4 py-2 rounded-lg">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-500 transition text-white text-sm font-semibold px-4 py-2 rounded-lg">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
