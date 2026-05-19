<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\Tanah;
use App\Models\Penyewa;
use Illuminate\Http\Request;

class KontrakController extends Controller
{
    public function index()
    {
        $kontraks = Kontrak::with(['tanah', 'penyewa'])->latest()->get();
        return view('kontrak.index', compact('kontraks'));
    }

    public function show(Kontrak $kontrak)
    {
        $kontrak->load(['tanah', 'penyewa', 'pembayarans']);
        return view('kontrak.show', compact('kontrak'));
    }

    public function create()
    {
        $tanahs = Tanah::where('status', 'tersedia')->get();
        $penyewas = Penyewa::all();
        return view('kontrak.form', compact('tanahs', 'penyewas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kontrak' => 'required|unique:kontrak',
            'tanah_id' => 'required|exists:tanah,id',
            'penyewa_id' => 'required|exists:penyewa,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'biaya_sewa_total' => 'required|numeric|min:0',
            'jumlah_cicilan' => 'required|integer|min:1',
            'keterangan' => 'nullable',
        ]);

        $kontrak = Kontrak::create($validated);

        // Update status tanah
        Tanah::where('id', $validated['tanah_id'])->update(['status' => 'disewa']);

        // Auto-generate pembayaran cicilan
        $biayaPerCicilan = $validated['biaya_sewa_total'] / $validated['jumlah_cicilan'];
        for ($i = 1; $i <= $validated['jumlah_cicilan']; $i++) {
            $jatuhTempo = date('Y-m-d', strtotime($validated['tanggal_mulai'] . " +{$i} month"));
            $kontrak->pembayarans()->create([
                'cicilan_ke' => $i,
                'jumlah' => $biayaPerCicilan,
                'tanggal_jatuh_tempo' => $jatuhTempo,
                'status' => 'belum_dibayar',
            ]);
        }

        return redirect()->route('kontrak.index')
            ->with('success', 'Kontrak berhasil dibuat.');
    }
}
