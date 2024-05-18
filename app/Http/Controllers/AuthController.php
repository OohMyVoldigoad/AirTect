<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginProcess(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        try {
            // Cari pengguna berdasarkan email
            $user = \App\Models\User::where('email', $request->email)->first();

            if ($user) {
                // Jika pengguna ditemukan, coba untuk memverifikasi password
                if (Auth::attempt($credentials)) {
                    // Jika autentikasi berhasil
                    $authenticatedUser = Auth::user();
                    $request->session()->regenerate();
                    return redirect()->route('dashboardAdmin')->with(['user' => $authenticatedUser]);
                } else {
                    // Jika password tidak cocok
                    return redirect()->back()->withInput()->withErrors(['password' => 'Password incorrect.']);
                }
            } else {
                // Jika pengguna tidak ditemukan
                return redirect()->back()->withInput()->withErrors(['email' => 'Email incorrect.']);
            }
        } catch (\Exception $e) {
            // Tangkap semua pengecualian dan log kesalahan
            \Log::error('Login error: ' . $e->getMessage());

            // Kembalikan pesan kesalahan ke pengguna
            return redirect()->back()->withInput()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }
    public function logout(Request $request): RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginPage')->with([
            'notifikasi' => 'Anda berhasil logout !',
            'type' => 'success'
        ]);
    }
}
