<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Transaksi;


class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $logs = LogAktivitas::with('user')->orderBy('created_at', 'desc')->get();
        $transaksiCount = Transaksi::count(); // hitung semua transaksi

        return view('admin.dashboard', compact('users', 'logs', 'transaksiCount'));
    }

    public function log()
    {
        $logs = LogAktivitas::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.log', compact('logs'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|in:kasir,manajer,admin',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Admin mengedit user ' . $user->name,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil diperbarui');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:kasir,manajer,admin',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Admin menambahkan user ' . $request->name . ' dengan role ' . $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User baru berhasil ditambahkan');
    }
}