<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Movierate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex items-center justify-center relative overflow-hidden"
      x-data="{ showPassword: false, showConfirm: false }">

    {{-- Background ambient blobs --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-purple-600/25 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-blue-600/25 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-sm bg-white/10 backdrop-blur-2xl border border-white/20 rounded-2xl p-8 shadow-2xl shadow-black/50">
        <div class="text-center mb-6">
            <div class="text-xl font-bold text-indigo-400 tracking-wider">MOVIERATE</div>
            <p class="text-sm text-gray-400 mt-1">Buat akun baru</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-300 text-sm px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm text-gray-400 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full bg-white/5 border border-white/15 rounded-lg px-4 py-2 text-sm text-white transition focus:outline-none focus:border-indigo-400 focus:bg-white/10">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
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
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                        class="w-full bg-white/5 border border-white/15 rounded-lg px-4 py-2 pr-10 text-sm text-white transition focus:outline-none focus:border-indigo-400 focus:bg-white/10">
                    <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white text-xs transition">
                        <span x-show="!showConfirm">Show</span>
                        <span x-show="showConfirm" x-cloak>Hide</span>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="btn-liquid w-full bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold py-2.5 rounded-lg shadow-lg shadow-indigo-600/30">
                Daftar
            </button>

            <p class="text-center text-xs text-gray-500">
                Sudah punya akun?
                <a href="{{ route('user.browse') }}" class="text-indigo-400 hover:text-indigo-300 transition">Login lewat beranda</a>
            </p>
        </form>
    </div>

</body>
</html>
