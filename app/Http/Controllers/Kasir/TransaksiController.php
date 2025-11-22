<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create()
    {
        $menus = Menu::all();
        return view('kasir.transaksi.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required',
            'menu_id' => 'required|array',
            'pembayaran_tunai' => 'required|numeric|min:0',
        ]);

        $total = 0;
        $detail = [];

        foreach ($request->menu_id as $menuId) {
            $menu = Menu::findOrFail($menuId);
            $jumlah = $request->jumlah[$menuId] ?? 1;

            $subtotal = $menu->harga * $jumlah;
            $total += $subtotal;

            $detail[] = [
                'menu_id' => $menuId,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        if ($request->pembayaran_tunai < $total) {
            return back()->withErrors('Pembayaran kurang dari total harga');
        }

        $tanggal = now()->format('Ymd');
        $countToday = Transaksi::whereDate('tanggal_transaksi', now()->toDateString())->count() + 1;
        $kodeTransaksi = 'TRX-' . $tanggal . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        $transaksi = Transaksi::create([
            'kode_transaksi'   => $kodeTransaksi,
            'id_kasir'         => auth()->id(),
            'nomor_meja'       => $request->nomor_meja,
            'total_harga'      => $total,
            'pembayaran_tunai' => $request->pembayaran_tunai,
            'kembalian'        => $request->pembayaran_tunai - $total,
            'tanggal_transaksi'=> now(),
        ]);

        foreach ($detail as $d) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_menu'      => $d['menu_id'],
                'jumlah'       => $d['jumlah'],
                'subtotal'     => $d['subtotal'],
            ]);
        }

        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Membuat transaksi ' . $transaksi->kode_transaksi,
        ]);

        return redirect()->route('kasir.dashboard')->with('success', 'Transaksi berhasil disimpan');
    }
}