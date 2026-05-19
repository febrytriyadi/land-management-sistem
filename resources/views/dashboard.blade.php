@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    @php
        use App\Models\Tanah;
        use App\Models\Kontrak;
        use App\Models\Pembayaran;
        use App\Models\Penyewa;

        $totalTanah = Tanah::count();
        $tanahDisewa = Tanah::where('status', 'disewa')->count();
        $totalPenyewa = Penyewa::count();
        $kontrakAktif = Kontrak::where('status', 'aktif')->count();
        $totalPendapatan = Pembayaran::where('status', 'lunas')->sum('jumlah');
        $tagihanBelum = Pembayaran::where('status', 'belum_dibayar')->sum('jumlah');
        $tagihanTerlambat = Pembayaran::where('status', 'terlambat')->count();
        $pembayaranTerbaru = Pembayaran::with('kontrak.tanah', 'kontrak.penyewa')->latest()->take(5)->get();
    @endphp

    <!-- Welcome -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-forest-700 via-forest-600 to-forest-800 p-6 lg:p-8" data-aos="fade-up">
        <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,0.04) 1px,transparent 1px);background-size:24px 24px"></div>
        <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-forest-400/10 blur-3xl"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2.5 mb-2">
                <span class="px-3 py-1 rounded-full bg-white/10 text-[10px] font-bold text-cream-200/80 border border-white/10 flex items-center gap-1.5">
                    <i class="bi bi-building text-xs"></i> PT Inhutani I
                </span>
                <span class="px-3 py-1 rounded-full bg-emerald-500/15 text-[10px] font-bold text-emerald-300 border border-emerald-500/15 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Live
                </span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-display font-extrabold text-white mt-3 leading-tight">
                Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-cream-200 to-cream-100">Yang Mulia</span>
                <span class="inline-block ml-1">👑</span>
            </h1>
            <p class="text-cream-200/60 mt-1.5 max-w-xl text-sm leading-relaxed">Sistem manajemen aset tanah terintegrasi — pantau kontrak, pembayaran, dan notifikasi dalam satu dashboard.</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4" data-aos="fade-up" data-aos-delay="50">
        @php
            $stats = [
                ['icon' => 'bi-geo-alt-fill', 'label' => 'Total Tanah', 'value' => $totalTanah, 'sub' => $tanahDisewa.' tanah disewa', 'from' => 'from-emerald-500', 'to' => 'to-green-600', 'bg' => 'from-emerald-50 to-green-50'],
                ['icon' => 'bi-people-fill', 'label' => 'Penyewa Aktif', 'value' => $totalPenyewa, 'sub' => $kontrakAktif.' kontrak aktif', 'from' => 'from-blue-500', 'to' => 'to-indigo-600', 'bg' => 'from-blue-50 to-indigo-50'],
                ['icon' => 'bi-cash-stack', 'label' => 'Pendapatan', 'value' => 'Rp '.number_format($totalPendapatan,0,',','.'), 'sub' => 'Total pembayaran lunas', 'from' => 'from-emerald-500', 'to' => 'to-teal-600', 'bg' => 'from-emerald-50 to-teal-50'],
                ['icon' => 'bi-clock-fill', 'label' => 'Tagihan Belum Bayar', 'value' => 'Rp '.number_format($tagihanBelum,0,',','.'), 'sub' => $tagihanTerlambat.' tagihan terlambat', 'from' => 'from-amber-500', 'to' => 'to-orange-600', 'bg' => 'from-amber-50 to-orange-50'],
            ];
        @endphp
        @foreach($stats as $s)
            <div class="card-premium bg-gradient-to-br {{ $s['bg'] }} border border-white/50 p-4 lg:p-5 shadow-sm hover:shadow-lg" data-aos="fade-up" data-aos-delay="{{ 80+$loop->index*50 }}">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-white/80 flex items-center justify-center text-lg shadow-sm border border-white/50 group-hover:scale-110 transition-transform" style="color:#2D5A27">
                        <i class="{{ $s['icon'] }}"></i>
                    </div>
                </div>
                <p class="text-[11px] font-medium text-gray-400 mb-0.5">{{ $s['label'] }}</p>
                <p class="text-xl lg:text-2xl font-display font-extrabold text-gray-900 tracking-tight">{{ $s['value'] }}</p>
                <p class="text-[11px] text-gray-400 mt-1">{{ $s['sub'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-5">
        <!-- Status Tanah -->
        <div class="card-premium glass-card p-5 lg:p-6" data-aos="fade-up" data-aos-delay="250">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="bi bi-pie-chart-fill text-forest-600"></i> Status Tanah
                </h3>
                <span class="text-[10px] font-bold bg-forest-50 text-forest-700 px-2.5 py-1 rounded-full">{{ $totalTanah }} Total</span>
            </div>
            @php $tersedia = $totalTanah - $tanahDisewa; $pct = $totalTanah > 0 ? round($tanahDisewa/$totalTanah*100) : 0; @endphp
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="font-semibold text-gray-600">Tersedia</span>
                        <span class="font-bold text-emerald-600">{{ $tersedia }}</span>
                    </div>
                    <div class="h-3 bg-cream-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full transition-all duration-1000" style="width:{{ $totalTanah>0?($tersedia/$totalTanah*100):0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="font-semibold text-gray-600">Disewa</span>
                        <span class="font-bold text-blue-600">{{ $tanahDisewa }}</span>
                    </div>
                    <div class="h-3 bg-cream-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-400 to-blue-500 rounded-full transition-all duration-1000" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-cream-100 flex items-center justify-center gap-1.5 text-xs text-gray-400">
                <span>Utilisasi:</span>
                <span class="text-lg font-display font-extrabold text-forest-600">{{ $pct }}%</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card-premium glass-card p-5 lg:p-6" data-aos="fade-up" data-aos-delay="300">
            <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-4">
                <i class="bi bi-lightning-fill text-amber-500"></i> Aksi Cepat
            </h3>
            <div class="grid grid-cols-2 gap-2.5">
                @php
                    $acts = [
                        ['icon' => 'bi-tree', 'label' => 'Tambah Tanah', 'link' => route('tanah.create'), 'color' => 'text-emerald-600'],
                        ['icon' => 'bi-person-plus', 'label' => 'Tambah Penyewa', 'link' => route('penyewa.create'), 'color' => 'text-blue-600'],
                        ['icon' => 'bi-file-earmark-plus', 'label' => 'Buat Kontrak', 'link' => route('kontrak.create'), 'color' => 'text-violet-600'],
                        ['icon' => 'bi-eye', 'label' => 'Lihat Tanah', 'link' => route('tanah.index'), 'color' => 'text-teal-600'],
                    ];
                @endphp
                @foreach($acts as $a)
                    <a href="{{ $a['link'] }}" 
                       class="group flex flex-col items-center gap-1.5 p-3.5 rounded-xl bg-cream-50/80 hover:bg-white border border-cream-100/50 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md active:scale-[0.98]">
                        <i class="{{ $a['icon'] }} {{ $a['color'] }} text-xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-[10px] font-semibold text-gray-600 group-hover:text-forest-700 transition-colors">{{ $a['label'] }}</span>
                    </a>
                @endforeach
            </div>
            <form action="{{ route('pembayaran.notifikasi-semua') }}" method="POST" class="mt-2.5">
                @csrf
                <button type="submit" 
                        class="w-full py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold text-xs transition-all duration-500 hover:shadow-lg hover:shadow-amber-500/30 hover:-translate-y-0.5 active:scale-[0.98] flex items-center justify-center gap-2">
                    <i class="bi bi-send-fill"></i> Kirim Notifikasi Tagihan
                </button>
            </form>
        </div>

        <!-- Ringkasan -->
        <div class="card-premium glass-card p-5 lg:p-6" data-aos="fade-up" data-aos-delay="350">
            <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-4">
                <i class="bi bi-journal-text text-forest-600"></i> Ringkasan Kontrak
            </h3>
            <div class="space-y-2.5">
                @php $kontrakTerbaru = Kontrak::with('penyewa','tanah')->latest()->take(3)->get(); @endphp
                @forelse($kontrakTerbaru as $k)
                    <a href="{{ route('kontrak.show', $k) }}" class="block p-3 rounded-xl bg-cream-50/50 hover:bg-cream-100 border border-cream-100/30 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-gray-800 truncate">{{ $k->no_kontrak }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5 truncate">{{ $k->penyewa->nama }}</p>
                            </div>
                            <span class="badge badge-{{ $k->status }} text-[9px] shrink-0">{{ ucfirst($k->status) }}</span>
                        </div>
                    </a>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada kontrak</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pembayaran Terbaru -->
    <div class="card-premium glass-card p-5 lg:p-6" data-aos="fade-up" data-aos-delay="400">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2">
                <i class="bi bi-credit-card-2-front-fill text-emerald-600"></i> Pembayaran Terbaru
            </h3>
            <a href="{{ route('pembayaran.index') }}" class="text-xs font-semibold text-forest-600 hover:text-forest-700 flex items-center gap-1">
                Lihat Semua <i class="bi bi-chevron-right text-[10px]"></i>
            </a>
        </div>
        <div class="table-modern-wrap">
            <table class="table-modern">
                <thead>
                    <tr><th>Tanah</th><th>Penyewa</th><th class="text-right">Jumlah</th><th class="text-center">Status</th></tr>
                </thead>
                <tbody>
                    @forelse($pembayaranTerbaru as $p)
                        <tr>
                            <td class="font-semibold text-gray-800 text-xs">{{ $p->kontrak->tanah->nama }}</td>
                            <td class="text-gray-500 text-xs">{{ $p->kontrak->penyewa->nama }}</td>
                            <td class="text-right font-bold text-gray-900 text-xs">Rp {{ number_format($p->jumlah,0,',','.') }}</td>
                            <td class="text-center"><span class="badge badge-{{ $p->status }}">{{ str_replace('_',' ',ucfirst($p->status)) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-8 text-gray-400 text-xs">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
