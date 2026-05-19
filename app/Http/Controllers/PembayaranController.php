<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Kontrak;
use App\Mail\TagihanMail;
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
