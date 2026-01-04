<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function tampilkanFormLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function prosesLogin(LoginRequest $request)
    {
        $kredensial = $request->only('email', 'password');

        if (Auth::attempt($kredensial, $request->filled('ingat_saya'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('pesan_sukses', 'Selamat datang, Admin!');
            }

            return redirect()->route('beranda')->with('pesan_sukses', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan halaman register.
     */
    public function tampilkanFormRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses register.
     */
    public function prosesRegister(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('beranda')->with('pesan_sukses', 'Registrasi berhasil! Selamat datang.');
    }

    /**
     * Proses logout.
     */
    public function prosesLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('pesan_sukses', 'Anda telah keluar dari sistem.');
    }
}
