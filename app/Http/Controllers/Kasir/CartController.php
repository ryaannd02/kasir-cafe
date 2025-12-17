<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    public function add(Request $request, Menu $menu)
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

    public function remove(Menu $menu)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$menu->id])) {
            unset($cart[$menu->id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('kasir.dashboard')->with('success', 'Menu dihapus dari keranjang');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('kasir.dashboard')->with('success', 'Keranjang dikosongkan');
    }
}