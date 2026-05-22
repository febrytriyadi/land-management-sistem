<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Kontrak;
use App\Mail\TagihanMail;
use App\Models\Tanah;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('kontrak.tanah', 'kontrak.penyewa')
            ->latest()
            ->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function bayar(Pembayaran $pembayaran)
    {
        if ($pembayaran->status === 'lunas') {
            return back()->with('error', 'Pembayaran ini sudah lunas.');
        }

        $pembayaran->update([
            'status' => 'lunas',
            'tanggal_bayar' => now(),
            'metode_pembayaran' => 'Transfer Bank',
        ]);

        // Cek apakah semua cicilan sudah lunas
        $kontrak = $pembayaran->kontrak;
        $sisaBelumLunas = $kontrak->pembayarans()->where('status', '!=', 'lunas')->count();
        if ($sisaBelumLunas === 0) {
            $kontrak->update(['status' => 'selesai']);
        }

        return back()->with('success', 'Pembayaran cicilan ke-' . $pembayaran->cicilan_ke . ' berhasil dikonfirmasi.');
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'metode_pembayaran' => 'nullable|string|max:100',
            'status' => 'nullable|in:belum_dibayar,lunas,terlambat',
            'tanggal_bayar' => 'nullable|date',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $data = $request->only(['jumlah', 'metode_pembayaran', 'keterangan']);

        if ($request->filled('tanggal_jatuh_tempo')) {
            $data['tanggal_jatuh_tempo'] = $request->tanggal_jatuh_tempo;
        }

        // Kalau status diubah jadi lunas, set tanggal_bayar
        if ($request->filled('status')) {
            $data['status'] = $request->status;
            if ($request->status === 'lunas' && !$pembayaran->tanggal_bayar) {
                $data['tanggal_bayar'] = $request->filled('tanggal_bayar')
                    ? $request->tanggal_bayar
                    : now()->toDateString();
            }
        }

        // Kalau user kirim tanggal_bayar manual
        if ($request->filled('tanggal_bayar') && $data['status'] ?? $pembayaran->status === 'lunas') {
            $data['tanggal_bayar'] = $request->tanggal_bayar;
        }

        $pembayaran->update($data);

        // Update status kontrak jika semua cicilan lunas
        $kontrak = $pembayaran->kontrak;
        $sisaBelumLunas = $kontrak->pembayarans()->where('status', '!=', 'lunas')->count();
        if ($sisaBelumLunas === 0) {
            $kontrak->update(['status' => 'selesai']);
        } elseif ($kontrak->status === 'selesai') {
            // Jika ada yang diubah jadi belum_dibayar, kembalikan status kontrak
            $kontrak->update(['status' => 'aktif']);
        }

        return back()->with('success', 'Pembayaran cicilan ke-' . $pembayaran->cicilan_ke . ' berhasil diperbarui.');
    }

    public function invoice(Pembayaran $pembayaran)
    {
        $pembayaran->load('kontrak.tanah', 'kontrak.penyewa');
        return view('pembayaran.invoice', compact('pembayaran'));
    }

    public function kirimNotifikasi(Pembayaran $pembayaran)
    {
        try {
            Mail::to($pembayaran->kontrak->penyewa->email)
                ->send(new TagihanMail($pembayaran));

            return back()->with('success', 'Notifikasi tagihan berhasil dikirim ke ' . $pembayaran->kontrak->penyewa->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    public function kirimSemuaNotifikasi()
    {
        $pembayarans = Pembayaran::with('kontrak.penyewa')
            ->where('status', 'belum_dibayar')
            ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(7))
            ->get();

        $terkirim = 0;
        $gagal = 0;

        foreach ($pembayarans as $p) {
            try {
                Mail::to($p->kontrak->penyewa->email)
                    ->send(new TagihanMail($p));
                $terkirim++;
            } catch (\Exception $e) {
                $gagal++;
            }
        }

        return back()->with('success', "Notifikasi: {$terkirim} terkirim, {$gagal} gagal.");
    }
}
