<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movierate - Laravel UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }

        * { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent; }

        body { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .glass-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .glass-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255,255,255,0.35);
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.5);
        }

        .btn-liquid {
            transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
        }
        .btn-liquid:hover { transform: translateY(-2px); filter: brightness(1.1); }
        .btn-liquid:active { transform: translateY(0) scale(0.97); }

        .modal-enter { animation: modalIn 0.25s ease-out; }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .blob { animation: float 12s ease-in-out infinite; }
        .blob-2 { animation: float 14s ease-in-out infinite reverse; }
        .blob-3 { animation: float 16s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.001ms !important; transition-duration: 0.001ms !important; }
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen relative overflow-x-hidden"
      x-data="{ loginOpen: {{ $errors->any() ? 'true' : 'false' }}, logoutOpen: false, showPassword: false }"
      @open-login.window="loginOpen = true">

    {{-- Background ambient blobs --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="blob absolute -top-32 -left-32 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
        <div class="blob-2 absolute top-1/3 -right-32 w-96 h-96 bg-purple-600/25 rounded-full blur-3xl"></div>
        <div class="blob-3 absolute bottom-0 left-1/3 w-96 h-96 bg-blue-600/25 rounded-full blur-3xl"></div>
    </div>

    <!-- Navbar liquid glass -->
    <nav class="sticky top-4 mx-4 mt-4 z-40 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/15 shadow-lg shadow-black/20 px-6 py-4 flex items-center gap-6">
        <a href="{{ route('user.browse') }}" class="text-xl font-bold text-indigo-400 tracking-wider shrink-0 transition hover:text-indigo-300">
            MOVIERATE
        </a>

        <form action="{{ route('user.browse') }}" method="GET" class="flex-1 max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari film..."
                class="w-full bg-white/5 border border-white/15 rounded-full px-4 py-1.5 text-sm text-white placeholder-gray-400 transition focus:outline-none focus:border-indigo-400 focus:bg-white/10">
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
                <span class="text-sm text-gray-300 hidden sm:inline">
                    {{ auth()->user()->name }}
                    <span class="text-xs text-indigo-400 uppercase">({{ auth()->user()->role }})</span>
                </span>
                <button @click="logoutOpen = true"
                    class="btn-liquid text-sm bg-white/10 hover:bg-white/20 border border-white/15 transition px-3 py-1.5 rounded-full">
                    Logout
                </button>
            @else
                <button @click="loginOpen = true"
                    class="btn-liquid text-sm bg-indigo-600 hover:bg-indigo-500 transition px-4 py-1.5 rounded-full font-semibold shadow-lg shadow-indigo-600/30">
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
        class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-md bg-black/40"
        @click.self="loginOpen = false">

        <div x-show="loginOpen" class="modal-enter w-full max-w-sm bg-white/10 backdrop-blur-2xl border border-white/20 rounded-2xl p-8 shadow-2xl shadow-black/50 relative">
            <button @click="loginOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl leading-none transition hover:rotate-90 duration-200">&times;</button>

            <div class="text-center mb-6">
                <div class="text-xl font-bold text-indigo-400 tracking-wider">MOVIERATE</div>
                <p class="text-sm text-gray-400 mt-1">Masuk ke akun kamu</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-300 text-sm px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-white/5 border border-white/15 rounded-lg px-4 py-2 text-sm text-white transition focus:outline-none focus:border-indigo-400 focus:bg-white/10">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full bg-white/5 border border-white/15 rounded-lg px-4 py-2 pr-10 text-sm text-white transition focus:outline-none focus:border-indigo-400 focus:bg-white/10">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white text-xs transition">
                            <span x-show="!showPassword">Show</span>
                            <span x-show="showPassword" x-cloak>Hide</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded bg-white/5 border-white/20">
                    <label for="remember" class="text-sm text-gray-400">Ingat saya</label>
                </div>

                <button type="submit"
                    class="btn-liquid w-full bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold py-2.5 rounded-lg shadow-lg shadow-indigo-600/30">
                    Masuk
                </button>

                <p class="text-center text-xs text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 transition">Daftar</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div x-show="logoutOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-md bg-black/40"
        @click.self="logoutOpen = false">

        <div x-show="logoutOpen" class="modal-enter w-full max-w-sm bg-white/10 backdrop-blur-2xl border border-white/20 rounded-2xl p-6 shadow-2xl shadow-black/50 text-center">
            <p class="text-white font-medium mb-1">Yakin mau logout?</p>
            <p class="text-sm text-gray-400 mb-6">Kamu perlu login lagi buat akses fitur ini.</p>

            <div class="flex justify-center gap-3">
                <button @click="logoutOpen = false"
                    class="btn-liquid bg-white/10 hover:bg-white/20 border border-white/15 transition text-gray-200 text-sm font-semibold px-4 py-2 rounded-lg">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="btn-liquid bg-red-600 hover:bg-red-500 transition text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-lg shadow-red-600/30">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
