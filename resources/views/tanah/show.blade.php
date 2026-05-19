@extends('layouts.app')
@section('title', 'Detail Tanah — ' . $tanah->nama)

@section('content')
    <div data-aos="fade-up">
        <a href="{{ route('tanah.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-forest-600 hover:text-forest-700 transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Main -->
        <div class="lg:col-span-2 space-y-5">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-forest-700 via-forest-600 to-forest-800 p-6" data-aos="fade-up" data-aos-delay="30">
                <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,0.04) 1px,transparent 1px);background-size:24px 24px"></div>
                <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-forest-400/10 blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-display font-extrabold text-white">{{ $tanah->nama }}</h2>
                            <p class="text-cream-300/60 text-xs mt-0.5 font-mono">{{ $tanah->kode_tanah }}</p>
                        </div>
                        <span class="badge {{ $tanah->status==='tersedia'?'badge-tersedia':'badge-disewa' }}">{{ ucfirst($tanah->status) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3.5 border border-white/10">
                            <p class="text-cream-200/50 text-[10px] font-bold uppercase tracking-wider"><i class="bi bi-geo-alt-fill"></i> Lokasi</p>
                            <p class="text-white font-semibold text-sm mt-1">{{ $tanah->lokasi }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3.5 border border-white/10">
                            <p class="text-cream-200/50 text-[10px] font-bold uppercase tracking-wider"><i class="bi bi-rulers"></i> Luas</p>
                            <p class="text-white font-semibold text-sm mt-1">{{ number_format($tanah->luas_hektar,2) }} Hektar</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($tanah->deskripsi)
            <div class="card-premium glass-card p-5" data-aos="fade-up" data-aos-delay="60">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-2"><i class="bi bi-card-text text-forest-600"></i> Deskripsi</h3>
                <p class="text-xs text-gray-600 leading-relaxed">{{ $tanah->deskripsi }}</p>
            </div>
            @endif

            <div class="card-premium glass-card p-5" data-aos="fade-up" data-aos-delay="90">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-4"><i class="bi bi-file-earmark-text text-forest-600"></i> Riwayat Kontrak</h3>
                @forelse($tanah->kontraks as $k)
                <div class="flex items-center justify-between p-3 rounded-xl bg-cream-50/70 hover:bg-cream-100 border border-cream-100/40 transition-all mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-xs font-bold text-forest-700 shadow-sm">{{ substr($k->no_kontrak,-3) }}</div>
                        <div><p class="font-bold text-xs text-gray-800">{{ $k->no_kontrak }}</p><p class="text-[10px] text-gray-400 mt-0.5">{{ $k->penyewa->nama }}</p></div>
                    </div>
                    <div class="text-right"><span class="badge badge-{{ $k->status }}">{{ ucfirst($k->status) }}</span><p class="text-[10px] text-gray-400 mt-1">{{ $k->tanggal_mulai->format('d/m/Y') }} → {{ $k->tanggal_selesai->format('d/m/Y') }}</p></div>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-6">Belum ada kontrak. <a href="{{ route('kontrak.create') }}" class="text-forest-600 font-semibold">Buat kontrak</a></p>
                @endforelse
            </div>
        </div>

        <!-- Side -->
        <div class="space-y-5">
            <div class="card-premium glass-card p-5" data-aos="fade-up" data-aos-delay="60">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-4"><i class="bi bi-info-circle-fill text-forest-600"></i> Informasi</h3>
                <div class="space-y-2.5">
                    @php
                        $info = [
                            ['l'=>'Kode Tanah','v'=>$tanah->kode_tanah,'i'=>'bi-tag-fill'],
                            ['l'=>'Total Kontrak','v'=>$tanah->kontraks->count(),'i'=>'bi-file-earmark-text'],
                            ['l'=>'Status','v'=>ucfirst($tanah->status),'i'=>$tanah->status==='tersedia'?'bi-check-circle-fill':'bi-lock-fill'],
                            ['l'=>'Dibuat','v'=>$tanah->created_at->format('d M Y'),'i'=>'bi-calendar3'],
                        ];
                    @endphp
                    @foreach($info as $x)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-cream-50/50">
                        <span class="flex items-center gap-2 text-xs text-gray-500"><i class="{{ $x['i'] }} text-cream-400"></i> {{ $x['l'] }}</span>
                        <span class="text-xs font-bold text-gray-800">{{ $x['v'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-premium bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100/40 p-5" data-aos="fade-up" data-aos-delay="90">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-3"><i class="bi bi-lightning-fill text-amber-500"></i> Aksi</h3>
                <a href="{{ route('kontrak.create') }}" class="btn-primary w-full justify-center text-xs"><i class="bi bi-file-earmark-plus"></i> Buat Kontrak Baru</a>
            </div>
        </div>
    </div>
@endsection
