@extends('layouts.app')
@section('title', 'Data Penyewa')

@section('content')
    <div class="flex items-start sm:items-center justify-between gap-3 flex-col sm:flex-row" data-aos="fade-up">
        <div>
            <h2 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2"><i class="bi bi-people-fill text-forest-600"></i> Data Penyewa</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola data penyewa aset tanah</p>
        </div>
        <a href="{{ route('penyewa.create') }}" class="btn-primary text-xs"><i class="bi bi-plus-lg"></i> Tambah Penyewa</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($penyewas as $p)
            <div class="card-premium glass-card p-5 group" data-aos="fade-up" data-aos-delay="{{ $loop->index*40 }}">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-forest-100 to-emerald-100 flex items-center justify-center text-forest-700 font-display font-bold text-base shadow-sm group-hover:scale-110 transition-transform">
                        {{ strtoupper(substr($p->nama,0,1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-display font-bold text-gray-900 text-sm truncate">{{ $p->nama }}</h3>
                        <p class="text-[10px] font-medium text-forest-600 mt-0.5">{{ $p->perusahaan ?? 'Perorangan' }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-xs text-gray-500">
                    <div class="flex items-center gap-2.5"><i class="bi bi-envelope-fill text-cream-400 w-4"></i><span class="truncate">{{ $p->email }}</span></div>
                    <div class="flex items-center gap-2.5"><i class="bi bi-telephone-fill text-cream-400 w-4"></i><span>{{ $p->no_hp ?? '—' }}</span></div>
                </div>
                <div class="mt-4 pt-3 border-t border-cream-100/50">
                    <a href="{{ route('penyewa.edit', $p) }}" class="btn-outline w-full justify-center text-xs py-2.5"><i class="bi bi-pencil-fill"></i> Edit</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <i class="bi bi-people text-5xl text-cream-300 mb-3 block"></i>
                <p class="font-display font-bold text-gray-400">Belum ada data penyewa</p>
                <a href="{{ route('penyewa.create') }}" class="btn-primary mt-5 text-xs inline-flex"><i class="bi bi-plus-lg"></i> Tambah Penyewa</a>
            </div>
        @endforelse
    </div>
@endsection
