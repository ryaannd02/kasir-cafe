<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class ManajerController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::all();

        $query = Transaksi::with('kasir')->orderBy('created_at', 'desc');

        if ($request->filled('kasir_id')) {
            $query->where('id_kasir', $request->kasir_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        $transaksis = $query->get();
        $kasirs = User::where('role', 'kasir')->get();

        return view('manajer.dashboard', compact('menus', 'transaksis', 'kasirs'));
    }

    public function laporan(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        $bulan   = $request->bulan ?? now()->month;
        $tahun   = $request->tahun ?? now()->year;

        $pendapatanHarian = Transaksi::whereDate('tanggal_transaksi', $tanggal)
            ->sum('total_harga');

        $pendapatanBulanan = Transaksi::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->sum('total_harga');

        return view('manajer.laporan', compact('pendapatanHarian', 'pendapatanBulanan', 'tanggal', 'bulan', 'tahun'));
    }

    public function log()
    {
        $logs = LogAktivitas::with('user')->orderBy('created_at', 'desc')->get();
        return view('manajer.log', compact('logs'));
    }
}