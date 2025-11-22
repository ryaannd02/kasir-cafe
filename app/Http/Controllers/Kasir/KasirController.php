<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class KasirController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Kalau tidak ada user, redirect ke login
        if (!$user) {
            return redirect('/login')->withErrors('Silakan login terlebih dahulu');
        }

        // Ambil transaksi milik kasir ini
        $transaksis = Transaksi::where('id_kasir', $user->id)->get();

        return view('kasir.dashboard', compact('transaksis'));
    }
}