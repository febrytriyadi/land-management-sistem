@extends('layouts.app')
@section('title', 'Detail Kontrak — ' . $kontrak->no_kontrak)

@section('content')
    <div data-aos="fade-up">
        <a href="{{ route('kontrak.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-forest-600 hover:text-forest-700 transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">
            <!-- Hero -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-forest-700 via-forest-600 to-forest-800 p-6" data-aos="fade-up" data-aos-delay="30">
                <div class="absolute inset-0" style="background-image:radial-gradient(rgba(255,255,255,0.04) 1px,transparent 1px);background-size:24px 24px"></div>
                <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-forest-400/10 blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-display font-extrabold text-white">{{ $kontrak->no_kontrak }}</h2>
                            <p class="text-cream-300/60 text-xs mt-0.5">Kontrak Sewa Tanah</p>
                        </div>
                        <span class="badge badge-{{ $kontrak->status }}">{{ ucfirst($kontrak->status) }}</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2.5">
                        @php
                            $ci = [
                                ['i'=>'bi-tree-fill','l'=>'Tanah','v'=>$kontrak->tanah->nama],
                                ['i'=>'bi-person-badge','l'=>'Penyewa','v'=>$kontrak->penyewa->nama],
                                ['i'=>'bi-calendar3','l'=>'Periode','v'=>$kontrak->tanggal_mulai->format('d M Y').' - '.$kontrak->tanggal_selesai->format('d M Y')],
                                ['i'=>'bi-cash-stack','l'=>'Total','v'=>'Rp '.number_format($kontrak->biaya_sewa_total,0,',','.')],
                                ['i'=>'bi-pie-chart','l'=>'Per Cicilan','v'=>'Rp '.number_format($kontrak->biaya_per_cicilan,0,',','.')],
                                ['i'=>$kontrak->sisa_hari<30?'bi-exclamation-triangle-fill':'bi-check-circle-fill','l'=>'Sisa Hari','v'=>$kontrak->sisa_hari.' hari'],
                            ];
                        @endphp
                        @foreach($ci as $c)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                            <p class="text-cream-200/50 text-[10px] font-bold uppercase tracking-wider"><i class="{{ $c['i'] }}"></i> {{ $c['l'] }}</p>
                            <p class="text-white font-bold text-xs mt-1 {{ $c['i']==='bi-exclamation-triangle-fill'?'text-amber-300':'' }}">{{ $c['v'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="card-premium glass-card p-5" data-aos="fade-up" data-aos-delay="60">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-4"><i class="bi bi-cash-stack text-emerald-600"></i> Riwayat Pembayaran</h3>
                <div class="space-y-2">
                    @forelse($kontrak->pembayarans as $p)
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $p->status==='lunas'?'bg-emerald-50/70 border-emerald-100/40':($p->status==='terlambat'?'bg-red-50/70 border-red-100/40':'bg-amber-50/70 border-amber-100/40') }}">
                        <div class="w-2.5 h-2.5 rounded-full shrink-0 {{ $p->status==='lunas'?'bg-emerald-500':($p->status==='terlambat'?'bg-red-500':'bg-amber-500') }}"></div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-xs text-gray-800">Cicilan ke-{{ $p->cicilan_ke }} <span class="text-gray-400 font-normal">/ {{ $kontrak->jumlah_cicilan }}</span></p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Jatuh tempo: {{ $p->tanggal_jatuh_tempo->format('d M Y') }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-xs text-gray-900">Rp {{ number_format($p->jumlah,0,',','.') }}</p>
                            <span class="badge badge-{{ $p->status }} text-[9px] mt-0.5">{{ str_replace('_',' ',ucfirst($p->status)) }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-6">Belum ada pembayaran.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Side -->
        <div class="space-y-5">
            <div class="card-premium glass-card p-5" data-aos="fade-up" data-aos-delay="60">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-4"><i class="bi bi-person-badge text-blue-600"></i> Info Penyewa</h3>
                <div class="space-y-3">
                    @php
                        $pi = [
                            ['l'=>'Nama','v'=>$kontrak->penyewa->nama],
                            ['l'=>'Email','v'=>$kontrak->penyewa->email],
                            ['l'=>'No. HP','v'=>$kontrak->penyewa->no_hp ?? '—'],
                        ];
                    @endphp
                    @foreach($pi as $x)
                    <div class="p-3 rounded-xl bg-cream-50/70">
                        <p class="text-[10px] text-gray-400">{{ $x['l'] }}</p>
                        <p class="font-bold text-xs text-gray-800 break-all mt-0.5">{{ $x['v'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-premium bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100/40 p-5" data-aos="fade-up" data-aos-delay="90">
                <h3 class="font-display font-bold text-gray-900 text-sm flex items-center gap-2 mb-3"><i class="bi bi-lightning-fill text-amber-500"></i> Aksi</h3>
                <form action="{{ route('pembayaran.notifikasi-semua') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-warning w-full justify-center text-xs"><i class="bi bi-send-fill"></i> Kirim Notifikasi Tagihan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
