<?php

namespace App\Http\Controllers;

use App\Models\Tanah;
use Illuminate\Http\Request;

class TanahController extends Controller
{
    public function index()
    {
        $tanah = Tanah::withCount('kontraks')->latest()->get();
        return view('tanah.index', compact('tanah'));
    }

    public function show(Tanah $tanah)
    {
        $tanah->load('kontraks.penyewa');
        return view('tanah.show', compact('tanah'));
    }

    public function create()
    {
        $tanah = new Tanah();
        return view('tanah.form', compact('tanah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_tanah' => 'required|unique:tanah',
            'nama' => 'required',
            'lokasi' => 'required',
            'luas_hektar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'status' => 'required|in:tersedia,disewa',
        ]);

        Tanah::create($validated);

        return redirect()->route('tanah.index')
            ->with('success', 'Data tanah berhasil ditambahkan.');
    }

    public function edit(Tanah $tanah)
    {
        return view('tanah.form', compact('tanah'));
    }

    public function update(Request $request, Tanah $tanah)
    {
        $validated = $request->validate([
            'kode_tanah' => 'required|unique:tanah,kode_tanah,' . $tanah->id,
            'nama' => 'required',
            'lokasi' => 'required',
            'luas_hektar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'status' => 'required|in:tersedia,disewa',
        ]);

        $tanah->update($validated);

        return redirect()->route('tanah.index')
            ->with('success', 'Data tanah berhasil diperbarui.');
    }
}
