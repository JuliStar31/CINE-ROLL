<?php
// app/Http/Controllers/RegisterController.php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $existing = User::where('email', $request->email)->first();

        // Kalau email sudah dipakai TAPI sudah terverifikasi -> tetap tolak
        if ($existing && $existing->email_verified_at) {
            throw ValidationException::withMessages([
                'email' => 'Email sudah terdaftar. Silakan login.',
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                $existing ? Rule::unique('users')->ignore($existing->id) : 'unique:users,email',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $otp = (string) random_int(100000, 999999);

        // Kalau user lama belum verifikasi -> update datanya, bukan bikin baris baru
        if ($existing) {
            $existing->update([
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);
            $user = $existing;
        } else {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user',
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);
        }

        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        session(['otp_user_id' => $user->id]);

        return redirect()->route('otp.verify.form');
    }

    public function showOtpForm()
    {
        if (! session('otp_user_id')) {
            return redirect()->route('register');
        }

        $user = User::find(session('otp_user_id'));

        return view('auth.otp-verify', [
            'email' => $user->email,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = User::find(session('otp_user_id'));

        if (! $user) {
            return redirect()->route('register');
        }

        if ($user->otp_code !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        $user->update([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('otp_user_id');
        auth()->login($user);

        return redirect()->route('user.browse')->with('success', 'Akun berhasil diverifikasi!');
    }

    public function resendOtp()
    {
        $user = User::find(session('otp_user_id'));

        if (! $user) {
            return redirect()->route('register');
        }

        $otp = (string) random_int(100000, 999999);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        return back()->with('success', 'Kode OTP baru sudah dikirim.');
    }
}
