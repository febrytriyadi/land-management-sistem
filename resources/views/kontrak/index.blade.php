@extends('layouts.app')
@section('title', 'Kontrak Sewa')

@section('content')
    <div class="flex items-start sm:items-center justify-between gap-3 flex-col sm:flex-row" data-aos="fade-up">
        <div>
            <h2 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2"><i class="bi bi-file-earmark-text-fill text-forest-600"></i> Kontrak Sewa</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola kontrak sewa aset tanah</p>
        </div>
        <a href="{{ route('kontrak.create') }}" class="btn-primary text-xs"><i class="bi bi-plus-lg"></i> Buat Kontrak</a>
    </div>

    <!-- Summary Cards -->
    @php
        $totalKontrak = $kontraks->count();
        $aktif = $kontraks->where('status','aktif')->count();
        $selesai = $kontraks->where('status','selesai')->count();
    @endphp
    <div class="grid grid-cols-3 gap-3" data-aos="fade-up" data-aos-delay="20">
        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-emerald-700">{{ $totalKontrak }}</p>
            <p class="text-[10px] font-semibold text-emerald-600/60 mt-0.5">Total Kontrak</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-blue-700">{{ $aktif }}</p>
            <p class="text-[10px] font-semibold text-blue-600/60 mt-0.5">Aktif</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-gray-700">{{ $selesai }}</p>
            <p class="text-[10px] font-semibold text-gray-500/60 mt-0.5">Selesai</p>
        </div>
    </div>

    <div class="card-premium glass-card overflow-hidden" data-aos="fade-up" data-aos-delay="40">
        <div class="table-modern-wrap">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No. Kontrak</th>
                        <th>Tanah</th>
                        <th>Penyewa</th>
                        <th>Periode</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kontraks as $k)
                        <tr>
                            <td>
                                <span class="font-bold text-gray-800 text-xs">{{ $k->no_kontrak }}</span>
                            </td>
                            <td>
                                <span class="text-xs font-medium">{{ $k->tanah->nama }}</span>
                                <span class="block text-[10px] text-gray-400">{{ $k->tanah->kode_tanah }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-forest-50 flex items-center justify-center text-[9px] font-bold text-forest-600 shrink-0">
                                        {{ strtoupper(substr($k->penyewa->nama, 0, 1)) }}
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $k->penyewa->nama }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-1.5 text-xs">
                                    <span class="font-medium text-gray-700">{{ $k->tanggal_mulai->format('d/m/Y') }}</span>
                                    <i class="bi bi-arrow-right text-[8px] text-gray-300"></i>
                                    <span class="font-medium text-gray-700">{{ $k->tanggal_selesai->format('d/m/Y') }}</span>
                                </div>
                                @php
                                    $mulai = \Carbon\Carbon::parse($k->tanggal_mulai);
                                    $selesai = \Carbon\Carbon::parse($k->tanggal_selesai);
                                    $durasi = $mulai->diffInMonths($selesai);
                                @endphp
                                <span class="text-[10px] text-gray-400">{{ $durasi }} bulan</span>
                            </td>
                            <td class="text-right">
                                <div class="inline-flex flex-col items-end">
                                    <span class="font-bold text-gray-900 text-xs">Rp {{ number_format($k->biaya_sewa_total,0,',','.') }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $k->jumlah_cicilan }}× cicilan</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $k->status }}">{{ ucfirst($k->status) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('kontrak.show', $k) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-forest-50 text-forest-700 font-semibold text-[10px] transition-all duration-300 hover:bg-forest-600 hover:text-white active:scale-95 border border-forest-100/30">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <i class="bi bi-file-earmark-text text-4xl text-cream-300 mb-3 block"></i>
                                <p class="font-display font-bold text-gray-400 text-sm">Belum ada kontrak sewa</p>
                                <p class="text-xs text-gray-300 mt-1">Buat kontrak pertama untuk mulai mencatat sewa tanah</p>
                                <a href="{{ route('kontrak.create') }}" class="btn-primary text-xs mt-4 inline-flex"><i class="bi bi-plus-lg"></i> Buat Kontrak</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
