@extends('layouts.app')
@section('title', $penyewa->exists ? 'Edit Penyewa' : 'Tambah Penyewa')

@section('content')
    <div class="max-w-2xl" data-aos="fade-up" data-aos-delay="20">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-7">
            <a href="{{ route('penyewa.index') }}" class="w-9 h-9 rounded-xl bg-white border border-cream-200/60 flex items-center justify-center text-forest-600 hover:bg-forest-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-lg font-display font-bold text-gray-900">{{ $penyewa->exists ? 'Edit Penyewa' : 'Tambah Penyewa Baru' }}</h1>
                <p class="text-xs text-gray-400">Lengkapi data penyewa aset tanah</p>
            </div>
        </div>

        <form action="{{ $penyewa->exists ? route('penyewa.update', $penyewa) : route('penyewa.store') }}" method="POST" class="space-y-6">
            @csrf
            @if($penyewa->exists) @method('PUT') @endif

            {{-- Group: Identitas Penyewa --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600"><i class="bi bi-person-badge-fill"></i></div>
                    <div>
                        <h3 class="form-group-title">Identitas Penyewa</h3>
                        <p class="form-group-desc">Informasi personal dan kontak utama</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama',$penyewa->nama) }}" class="input-field @error('nama') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="Nama penyewa" required>
                        @error('nama') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Email</label>
                        <input type="email" name="email" value="{{ old('email',$penyewa->email) }}" class="input-field @error('email') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="email@example.com" required>
                        @error('email') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp',$penyewa->no_hp) }}" class="input-field @error('no_hp') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="08xxxxxxxxx">
                        @error('no_hp') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Perusahaan</label>
                        <input type="text" name="perusahaan" value="{{ old('perusahaan',$penyewa->perusahaan) }}" class="input-field @error('perusahaan') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="Nama perusahaan (opsional)">
                        @error('perusahaan') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Group: Alamat --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-600"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h3 class="form-group-title">Alamat</h3>
                        <p class="form-group-desc">Alamat lengkap penyewa</p>
                    </div>
                </div>
                <div>
                    <label class="input-label">Alamat Lengkap</label>
                    <textarea name="alamat" rows="4" class="input-field @error('alamat') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="Alamat lengkap penyewa...">{{ old('alamat',$penyewa->alamat) }}</textarea>
                    @error('alamat') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary text-sm px-7 py-3 shadow-lg shadow-blue-600/15">
                    <i class="bi bi-check-lg"></i> {{ $penyewa->exists ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
                <a href="{{ route('penyewa.index') }}" class="btn-outline text-sm px-7 py-3">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
