<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Supaya Laravel pakai kolom username, bukan email
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login dengan username & password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect sesuai role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'manajer':
                    return redirect()->route('manajer.dashboard');
                case 'kasir':
                    return redirect()->route('kasir.dashboard');
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors([
                        'login' => 'Role tidak dikenali',
                    ]);
            }
        }

        // Kalau gagal login
        return back()->withErrors([
            'login' => 'Username atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}