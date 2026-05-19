@extends('layouts.app')
@section('title', 'Data Tanah')

@section('content')
    <div class="flex items-start sm:items-center justify-between gap-3 flex-col sm:flex-row" data-aos="fade-up">
        <div>
            <h2 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2"><i class="bi bi-tree-fill text-forest-600"></i> Data Tanah</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola aset tanah PT Inhutani I</p>
        </div>
        <a href="{{ route('tanah.create') }}" class="btn-primary text-xs"><i class="bi bi-plus-lg"></i> Tambah Tanah</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($tanah as $t)
            <div class="card-premium glass-card p-5 group" data-aos="fade-up" data-aos-delay="{{ $loop->index*40 }}">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="font-display font-bold text-gray-900 text-sm group-hover:text-forest-600 transition-colors">{{ $t->nama }}</h3>
                        <p class="text-[10px] text-gray-400 font-mono mt-0.5">{{ $t->kode_tanah }}</p>
                    </div>
                    <span class="badge {{ $t->status==='tersedia'?'badge-tersedia':'badge-disewa' }}">{{ ucfirst($t->status) }}</span>
                </div>
                <div class="grid grid-cols-3 gap-2 mb-4">
                    <div class="bg-cream-50/70 rounded-xl p-2.5 text-center">
                        <p class="text-[9px] text-gray-400">Lokasi</p>
                        <p class="text-[10px] font-semibold text-gray-700 mt-0.5 truncate">{{ $t->lokasi }}</p>
                    </div>
                    <div class="bg-cream-50/70 rounded-xl p-2.5 text-center">
                        <p class="text-[9px] text-gray-400">Luas</p>
                        <p class="text-[10px] font-semibold text-gray-700 mt-0.5">{{ number_format($t->luas_hektar,1) }} Ha</p>
                    </div>
                    <div class="bg-cream-50/70 rounded-xl p-2.5 text-center">
                        <p class="text-[9px] text-gray-400">Kontrak</p>
                        <p class="text-[10px] font-semibold text-gray-700 mt-0.5">{{ $t->kontraks_count }}</p>
                    </div>
                </div>
                <a href="{{ route('tanah.show', $t) }}" class="btn-outline w-full justify-center text-xs py-2.5"><i class="bi bi-eye"></i> Lihat Detail</a>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <i class="bi bi-tree text-5xl text-cream-300 mb-3 block"></i>
                <p class="font-display font-bold text-gray-400">Belum ada data tanah</p>
                <a href="{{ route('tanah.create') }}" class="btn-primary mt-5 text-xs inline-flex"><i class="bi bi-plus-lg"></i> Tambah Tanah</a>
            </div>
        @endforelse
    </div>
@endsection
