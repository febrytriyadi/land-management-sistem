@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')
    <div class="flex items-start sm:items-center justify-between gap-3 flex-col sm:flex-row" data-aos="fade-up">
        <div>
            <h2 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2"><i class="bi bi-wallet-fill text-forest-600"></i> Pembayaran</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola pembayaran sewa tanah</p>
        </div>
        <form action="{{ route('pembayaran.notifikasi-semua') }}" method="POST">
            @csrf
            <button type="submit" class="btn-warning text-xs"><i class="bi bi-send-fill"></i> Kirim Semua Notifikasi</button>
        </form>
    </div>

    <!-- Stats Cards -->
    @php
        $totalBelum = App\Models\Pembayaran::where('status','belum_dibayar')->count();
        $totalLunas = App\Models\Pembayaran::where('status','lunas')->count();
        $totalTerlambat = App\Models\Pembayaran::where('status','terlambat')->count();
    @endphp
    <div class="grid grid-cols-3 gap-3" data-aos="fade-up" data-aos-delay="20">
        <div class="rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-amber-700">{{ $totalBelum }}</p>
            <p class="text-[10px] font-semibold text-amber-600/60 mt-0.5">Belum Dibayar</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-emerald-700">{{ $totalLunas }}</p>
            <p class="text-[10px] font-semibold text-emerald-600/60 mt-0.5">Lunas</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-red-50 to-red-100 border border-red-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-red-700">{{ $totalTerlambat }}</p>
            <p class="text-[10px] font-semibold text-red-600/60 mt-0.5">Terlambat</p>
        </div>
    </div>

    <div class="card-premium glass-card overflow-hidden" data-aos="fade-up" data-aos-delay="40">
        <div class="table-modern-wrap">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kontrak</th>
                        <th>Tanah</th>
                        <th>Penyewa</th>
                        <th class="text-center">Cicilan</th>
                        <th class="text-right">Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $p)
                        <tr class="{{ $p->status==='terlambat' ? 'bg-red-50/30' : ($p->status==='lunas' ? 'bg-emerald-50/20' : '') }}">
                            <td>
                                <span class="font-bold text-gray-800 text-xs">{{ $p->kontrak->no_kontrak }}</span>
                            </td>
                            <td>
                                <span class="text-xs font-medium">{{ $p->kontrak->tanah->nama }}</span>
                                <span class="block text-[10px] text-gray-400">{{ $p->kontrak->tanah->kode_tanah }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-forest-50 flex items-center justify-center text-[9px] font-bold text-forest-600 shrink-0">
                                        {{ strtoupper(substr($p->kontrak->penyewa->nama, 0, 1)) }}
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $p->kontrak->penyewa->nama }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <div class="w-7 h-7 rounded-lg bg-forest-50 flex items-center justify-center">
                                        <span class="font-bold text-forest-700 text-[11px]">{{ $p->cicilan_ke }}</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400">/ {{ $p->kontrak->jumlah_cicilan }}</span>
                                </div>
                            </td>
                            <td class="text-right">
                                <span class="font-bold text-gray-900 text-sm">Rp {{ number_format($p->jumlah,0,',','.') }}</span>
                            </td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium {{ $p->status==='terlambat' ? 'text-red-600' : 'text-gray-700' }}">
                                        {{ $p->tanggal_jatuh_tempo->format('d M Y') }}
                                    </span>
                                    @if($p->status==='terlambat')
                                        <span class="text-[10px] text-red-500 font-semibold flex items-center gap-1 mt-0.5">
                                            <i class="bi bi-exclamation-triangle-fill"></i> Terlambat {{ $p->terlambat }} hari
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $p->status }}">{{ str_replace('_',' ',ucfirst($p->status)) }}</span>
                            </td>
                            <td>
                                <div class="flex gap-1.5 justify-center">
                                    @if($p->status!=='lunas')
                                        <form action="{{ route('pembayaran.bayar',$p) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-semibold text-[10px] transition-all duration-300 hover:bg-emerald-600 hover:text-white active:scale-95 border border-emerald-200/40">
                                                <i class="bi bi-check-lg"></i> Bayar
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('pembayaran.notifikasi',$p) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-forest-50 text-forest-700 font-semibold text-[10px] transition-all duration-300 hover:bg-forest-600 hover:text-white active:scale-95 border border-forest-100/30">
                                            <i class="bi bi-envelope-fill"></i> Email
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-16">
                                <i class="bi bi-wallet text-4xl text-cream-300 mb-3 block"></i>
                                <p class="font-display font-bold text-gray-400 text-sm">Belum ada data pembayaran</p>
                                <p class="text-xs text-gray-300 mt-1">Pembayaran otomatis terbuat saat kontrak dibuat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
