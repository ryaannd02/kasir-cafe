<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\DetailTransaksi;
use App\Models\LogAktivitas;

class KasirController extends Controller
{
    // Halaman dashboard kasir
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->withErrors('Silakan login terlebih dahulu');
        }

        $menus = Menu::all();
        $transaksis = Transaksi::where('id_kasir', $user->id)
                        ->orderByDesc('tanggal_transaksi')
                        ->get();

        $cartItems = session('cart', []);
        $total = collect($cartItems)->sum('subtotal');

        return view('kasir.dashboard', compact('menus', 'transaksis', 'cartItems', 'total'));
    }

    // Tambah menu ke keranjang
    public function addToCart(Menu $menu)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['jumlah']++;
            $cart[$menu->id]['subtotal'] = $cart[$menu->id]['jumlah'] * $menu->harga;
        } else {
            $cart[$menu->id] = [
                'nama_menu' => $menu->nama_menu,
                'harga'     => $menu->harga,
                'jumlah'    => 1,
                'subtotal'  => $menu->harga,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('kasir.dashboard')->with('success', 'Menu ditambahkan ke keranjang');
    }

    // Tambah jumlah item di keranjang
    public function increaseCart(Menu $menu)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['jumlah']++;
            $cart[$menu->id]['subtotal'] = $cart[$menu->id]['jumlah'] * $menu->harga;
            session()->put('cart', $cart);
        }
        return redirect()->route('kasir.dashboard');
    }

    // Kurangi jumlah item di keranjang
    public function decreaseCart(Menu $menu)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['jumlah']--;
            if ($cart[$menu->id]['jumlah'] <= 0) {
                unset($cart[$menu->id]);
            } else {
                $cart[$menu->id]['subtotal'] = $cart[$menu->id]['jumlah'] * $menu->harga;
            }
            session()->put('cart', $cart);
        }
        return redirect()->route('kasir.dashboard');
    }

    // Hapus menu dari keranjang
    public function removeFromCart(Menu $menu)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$menu->id])) {
            unset($cart[$menu->id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('kasir.dashboard')->with('success', 'Menu dihapus dari keranjang');
    }

    // Kosongkan keranjang
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('kasir.dashboard')->with('success', 'Keranjang dikosongkan');
    }

    // Checkout transaksi
    public function checkout(Request $request)
    {
        $cartItems = session('cart', []);
        $total = collect($cartItems)->sum('subtotal');

        // Validasi keranjang kosong
        if (empty($cartItems)) {
            return redirect()->route('kasir.dashboard')
                ->withErrors(['cart' => 'Keranjang masih kosong, tidak bisa lanjut pembayaran.']);
        }

        // Validasi input
        $request->validate([
            'nomor_meja'       => 'required|string|max:255',
            'pembayaran_tunai' => 'required|numeric|min:'.$total,
        ], [
            'nomor_meja.required'       => 'Nomor meja wajib diisi.',
            'pembayaran_tunai.required' => 'Nominal pembayaran wajib diisi.',
            'pembayaran_tunai.min'      => 'Nominal pembayaran kurang dari total.',
        ]);

        // Generate kode transaksi unik per hari
        $tanggal     = now()->format('Ymd');
        $countToday  = Transaksi::whereDate('tanggal_transaksi', now()->toDateString())->count() + 1;
        $kodeTransaksi = 'TRX-' . $tanggal . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        // Simpan transaksi
        $transaksi = new Transaksi();
        $transaksi->nomor_meja        = $request->nomor_meja;
        $transaksi->kode_transaksi    = $kodeTransaksi;
        $transaksi->id_kasir          = Auth::id();
        $transaksi->tanggal_transaksi = now();
        $transaksi->total_harga       = $total;
        $transaksi->pembayaran_tunai  = $request->pembayaran_tunai;
        $transaksi->kembalian         = $request->pembayaran_tunai - $total;
        $transaksi->save();

        // Simpan detail transaksi dari cart
        foreach ($cartItems as $id => $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_menu'      => $id,
                'jumlah'       => $item['jumlah'],
                'subtotal'     => $item['subtotal'],
            ]);
        }

        // Log aktivitas
        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Kasir membuat transaksi ' . $transaksi->kode_transaksi,
        ]);

        // Kosongkan keranjang
        session()->forget('cart');

        // Redirect ke halaman show transaksi dengan kode
        return redirect()->route('kasir.transaksi.struk', $transaksi->kode_transaksi)
            ->with('success', 'Transaksi berhasil disimpan dan struk dicetak.')
            ->with('kembalian', $transaksi->kembalian);
            }
}