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
    // Dashboard manajer: daftar transaksi + filter
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

        // gunakan paginate agar bisa dipaginasi di view
        $transaksis = $query->paginate(10);
        $kasirs = User::where('role', 'kasir')->get();

        return view('manajer.dashboard', compact('menus', 'transaksis', 'kasirs'));
    }

    // Laporan pendapatan harian & bulanan
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

        return view('manajer.laporan', compact(
            'pendapatanHarian',
            'pendapatanBulanan',
            'tanggal',
            'bulan',
            'tahun'
        ));
    }

    // Log aktivitas pegawai
    public function log()
    {
        // gunakan paginate agar bisa dipanggil $logs->links() di Blade
        $logs = LogAktivitas::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('manajer.log', compact('logs'));
    }
}