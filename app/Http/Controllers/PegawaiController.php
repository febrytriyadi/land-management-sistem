<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = User::where('role', 'petugas')->latest()->get();
        $adminCount = User::where('role', 'admin')->count();
        $petugasCount = $pegawais->count();
        return view('pegawai.index', compact('pegawais', 'adminCount', 'petugasCount'));
    }

    public function create()
    {
        return view('pegawai.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,petugas',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(User $pegawai)
    {
        return view('pegawai.form', compact('pegawai'));
    }

    public function update(Request $request, User $pegawai)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pegawai->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,petugas',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(User $pegawai)
    {
        if ($pegawai->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $pegawai->delete();
        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
