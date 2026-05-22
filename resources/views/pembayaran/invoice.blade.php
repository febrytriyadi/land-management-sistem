<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice — {{ $pembayaran->kontrak->no_kontrak }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; }
        .font-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        @media print {
            body { background: white; padding: 0; margin: 0; }
            .no-print { display: none !important; }
            .print-page { box-shadow: none !important; border: 1px solid #e5e7eb !important; margin: 0 auto !important; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body class="p-4 sm:p-8">
    <!-- Tombol Print -->
    <div class="no-print max-w-3xl mx-auto mb-4 flex justify-between items-center">
        <a href="{{ url()->previous() }}" class="text-xs text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-1.5">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-forest-600 text-white font-semibold text-sm hover:bg-forest-700 transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Simpan PDF
        </button>
    </div>

    <!-- Invoice -->
    @php
        $kontrak = $pembayaran->kontrak;
        $tanah = $kontrak->tanah;
        $penyewa = $kontrak->penyewa;
        $nomorInvoice = 'INV/' . $kontrak->no_kontrak . '/' . str_pad($pembayaran->cicilan_ke, 2, '0', STR_PAD_LEFT);
    @endphp

    <div class="print-page max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Kop Surat -->
        <div class="border-b border-gray-200 px-8 pt-8 pb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="font-display text-2xl font-extrabold text-forest-700">PT INHUTANI I</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Perum Perhutani — Forestry Enterprise</p>
                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                        Jl. Letjen Soeprapto No. 08<br>
                        Jakarta Pusat 10410<br>
                        Indonesia
                    </p>
                </div>
                <div class="text-right">
                    <div class="bg-forest-600 text-white font-display font-bold text-sm px-5 py-2 rounded-xl inline-block">
                        TANDA TERIMA
                    </div>
                    <p class="text-[10px] text-gray-500 mt-2 font-mono">{{ $nomorInvoice }}</p>
                </div>
            </div>
        </div>

        <!-- Body Invoice -->
        <div class="px-8 py-6">
            <!-- Info: Penyewa & Tanah -->
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Diterima Dari</p>
                    <p class="font-bold text-gray-900 text-sm">{{ $penyewa->nama }}</p>
                    <p class="text-xs text-gray-500">{{ $penyewa->perusahaan ?? '-' }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $penyewa->alamat ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                    <p class="font-bold text-gray-900 text-sm">{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d M Y') : now()->format('d M Y') }}</p>
                    <p class="text-[10px] text-gray-400 mt-2">No. Kontrak: <span class="font-semibold">{{ $kontrak->no_kontrak }}</span></p>
                </div>
            </div>

            <!-- Detail Tanah -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <div class="grid grid-cols-3 gap-4 text-xs">
                    <div>
                        <p class="text-gray-400 mb-0.5">Objek Sewa</p>
                        <p class="font-semibold text-gray-800">{{ $tanah->nama }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-0.5">Kode Tanah</p>
                        <p class="font-semibold text-gray-800">{{ $tanah->kode_tanah }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-0.5">Lokasi</p>
                        <p class="font-semibold text-gray-800">{{ $tanah->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-0.5">Luas</p>
                        <p class="font-semibold text-gray-800">{{ number_format($tanah->luas_hektar, 2, ',', '.') }} Ha</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-0.5">Periode Sewa</p>
                        <p class="font-semibold text-gray-800">{{ $kontrak->tanggal_mulai->format('d/m/Y') }} — {{ $kontrak->tanggal_selesai->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-0.5">Cicilan Ke</p>
                        <p class="font-semibold text-gray-800">{{ $pembayaran->cicilan_ke }} / {{ $kontrak->jumlah_cicilan }}</p>
                    </div>
                </div>
            </div>

            <!-- Rincian Pembayaran -->
            <div class="border border-gray-200 rounded-xl overflow-hidden mb-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left text-[10px] font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Deskripsi</th>
                            <th class="text-right text-[10px] font-semibold text-gray-500 uppercase tracking-wider px-4 py-3">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-gray-100">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-800">Pembayaran Sewa Tanah — Cicilan ke-{{ $pembayaran->cicilan_ke }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Periode: {{ $pembayaran->tanggal_jatuh_tempo->format('M Y') }}</p>
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-gray-900 text-base">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @if($pembayaran->keterangan)
                        <tr class="border-t border-gray-100">
                            <td colspan="2" class="px-4 py-2">
                                <p class="text-[11px] text-gray-500 italic">“{{ $pembayaran->keterangan }}”</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-300 bg-gray-50/50">
                            <td class="px-4 py-3 font-bold text-gray-800 font-display">Total Dibayarkan</td>
                            <td class="px-4 py-3 text-right font-extrabold text-forest-700 text-lg font-display">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Status & Metode -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Status</p>
                    @php
                        $badgeClass = $pembayaran->status === 'lunas' ? 'bg-emerald-100 text-emerald-700' : ($pembayaran->status === 'terlambat' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700');
                    @endphp
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold {{ $badgeClass }}">
                        {{ $pembayaran->status === 'lunas' ? 'LUNAS' : ($pembayaran->status === 'terlambat' ? 'TERLAMBAT' : 'BELUM DIBAYAR') }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Metode Pembayaran</p>
                    <p class="font-semibold text-gray-800 text-sm">{{ $pembayaran->metode_pembayaran ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Tanda Tangan -->
        <div class="border-t border-gray-200 px-8 py-6 grid grid-cols-2 gap-8">
            <div class="text-center">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Penyewa</p>
                <div class="h-16"></div>
                <div class="border-t border-gray-300 pt-1">
                    <p class="font-bold text-gray-800 text-sm">{{ $penyewa->nama }}</p>
                </div>
            </div>
            <div class="text-center">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">PT Inhutani I</p>
                <div class="h-16"></div>
                <div class="border-t border-gray-300 pt-1">
                    <p class="font-bold text-gray-800 text-sm">Manajer</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 text-center">
            <p class="text-[10px] text-gray-400">Dokumen ini merupakan tanda terima pembayaran yang sah. Dicetak pada {{ now()->format('d M Y H:i') }}.</p>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</body>
</html>
