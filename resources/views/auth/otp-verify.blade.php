<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Movierate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 font-sans min-h-screen flex items-center justify-center">

    <div class="w-full max-w-sm bg-gray-800 border border-gray-700 rounded-xl p-8 shadow-lg">
        <div class="text-center mb-6">
            <div class="text-xl font-bold text-indigo-500 tracking-wider">MOVIERATE</div>
            <p class="text-sm text-gray-400 mt-1">Masukkan kode OTP yang dikirim ke</p>
            <p class="text-sm text-white font-medium">{{ $email }}</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-600/10 border border-green-500/30 text-green-400 text-sm px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-600/10 border border-red-500/30 text-red-400 text-sm px-4 py-3 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-400 mb-1">Kode OTP (6 digit)</label>
                <input type="text" name="otp" maxlength="6" inputmode="numeric" required autofocus
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-sm text-center tracking-[0.5em] focus:outline-none focus:border-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-500 transition text-white text-sm font-semibold py-2 rounded-lg">
                Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('otp.resend') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full text-center text-xs text-gray-400 hover:text-indigo-400">
                Belum dapat kode? Kirim ulang OTP
            </button>
        </form>
    </div>

</body>
</html>
