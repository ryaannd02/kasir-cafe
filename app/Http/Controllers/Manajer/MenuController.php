<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\LogAktivitas;

class MenuController extends Controller
{
    public function create()
    {
        return view('manajer.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
        ]);

        $menu = Menu::create($request->all());

        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambah menu ' . $menu->nama_menu,
        ]);

        return redirect()->route('manajer.dashboard')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('manajer.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mengubah menu ' . $menu->nama_menu,
        ]);

        return redirect()->route('manajer.dashboard')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menghapus menu ' . $menu->nama_menu,
        ]);

        return redirect()->route('manajer.dashboard')->with('success', 'Menu berhasil dihapus');
    }
}