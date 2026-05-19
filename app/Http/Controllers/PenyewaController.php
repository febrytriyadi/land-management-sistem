<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewas = Penyewa::withCount('kontraks')->latest()->get();
        return view('penyewa.index', compact('penyewas'));
    }

    public function create()
    {
        $penyewa = new Penyewa();
        return view('penyewa.form', compact('penyewa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:penyewa',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
            'perusahaan' => 'nullable',
        ]);

        Penyewa::create($validated);

        return redirect()->route('penyewa.index')
            ->with('success', 'Penyewa berhasil ditambahkan.');
    }

    public function edit(Penyewa $penyewa)
    {
        return view('penyewa.form', compact('penyewa'));
    }

    public function update(Request $request, Penyewa $penyewa)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:penyewa,email,' . $penyewa->id,
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
            'perusahaan' => 'nullable',
        ]);

        $penyewa->update($validated);

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil diupdate.');
    }
}
