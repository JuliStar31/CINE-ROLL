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
<body class="bg-gray-900 text-gray-100 font-sans min-h-screen flex items-center justify-center"
      x-data="{ showPassword: false, showConfirm: false }">

    <div class="w-full max-w-sm bg-gray-800 border border-gray-700 rounded-xl p-8 shadow-lg">
        <div class="text-center mb-6">
            <div class="text-xl font-bold text-indigo-500 tracking-wider">MOVIERATE</div>
            <p class="text-sm text-gray-400 mt-1">Buat akun baru</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-600/10 border border-red-500/30 text-red-400 text-sm px-4 py-3 rounded-lg">
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
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
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
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 pr-10 text-sm focus:outline-none focus:border-indigo-500">
                    <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white text-xs">
                        <span x-show="!showConfirm">Show</span>
                        <span x-show="showConfirm" x-cloak>Hide</span>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold py-2 rounded-lg">
                Daftar
            </button>

            <p class="text-center text-xs text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">Login</a>
            </p>
        </form>
    </div>

</body>
</html>
