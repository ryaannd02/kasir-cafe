<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\LogAktivitas;

class TransaksiController extends Controller
{
    // Halaman daftar riwayat transaksi kasir + filter
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->withErrors('Silakan login terlebih dahulu');
        }

        $query = Transaksi::where('id_kasir', $user->id);

        // Filter tanggal dari & sampai
        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal_transaksi', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59'
            ]);
        } elseif ($request->filled('dari')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->dari);
        } elseif ($request->filled('sampai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->sampai);
        }

        // Filter nomor meja
        if ($request->filled('nomor_meja')) {
            $query->where('nomor_meja', 'like', '%' . $request->nomor_meja . '%');
        }

        $transaksis = $query->orderByDesc('tanggal_transaksi')->paginate(10);

        return view('kasir.transaksi.index', compact('transaksis'));
    }

    // Detail transaksi tertentu (pakai kode_transaksi)
    public function show($kode)
    {
        $trx = Transaksi::with(['kasir','details.menu'])
            ->where('kode_transaksi', $kode)
            ->firstOrFail();

        return view('kasir.transaksi.show', compact('trx'));
    }

    // Versi struk siap cetak
    public function struk($kode)
    {
        $trx = Transaksi::with(['kasir','details.menu'])
            ->where('kode_transaksi', $kode)
            ->firstOrFail();

        return view('kasir.transaksi.struk', compact('trx'));
    }

    // Form buat transaksi baru
    public function create()
    {
        $menus = Menu::all();
        return view('kasir.transaksi.create', compact('menus'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja'       => 'required|string|max:10',
            'menu_id'          => 'required|array|min:1',
            'pembayaran_tunai' => 'required|numeric|min:0',
        ]);

        $total  = 0;
        $detail = [];

        foreach ($request->menu_id as $menuId) {
            $menu   = Menu::findOrFail($menuId);
            $jumlah = $request->jumlah[$menuId] ?? 1;

            $subtotal = $menu->harga * $jumlah;
            $total   += $subtotal;

            $detail[] = [
                'menu_id'  => $menuId,
                'jumlah'   => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        if ($request->pembayaran_tunai < $total) {
            return back()->withErrors('Pembayaran kurang dari total harga');
        }

        // Generate kode transaksi unik per hari
        $tanggal     = now()->format('Ymd');
        $countToday  = Transaksi::whereDate('tanggal_transaksi', now()->toDateString())->count() + 1;
        $kodeTransaksi = 'TRX-' . $tanggal . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi'    => $kodeTransaksi,
            'id_kasir'          => auth()->id(),
            'nomor_meja'        => $request->nomor_meja,
            'total_harga'       => $total,
            'pembayaran_tunai'  => $request->pembayaran_tunai,
            'kembalian'         => $request->pembayaran_tunai - $total,
            'tanggal_transaksi' => now(),
        ]);

        // Simpan detail transaksi
        foreach ($detail as $d) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_menu'      => $d['menu_id'],
                'jumlah'       => $d['jumlah'],
                'subtotal'     => $d['subtotal'],
            ]);
        }

        // Log aktivitas
        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => 'Kasir membuat transaksi ' . $transaksi->kode_transaksi,
        ]);

        // Redirect ke halaman struk (langsung siap cetak)
        return redirect()->route('kasir.transaksi.struk', $transaksi->kode_transaksi)
                         ->with('success', 'Transaksi berhasil disimpan');
    }
}