@extends('layouts.app')
@section('title', $tanah->exists ? 'Edit Tanah' : 'Tambah Tanah')

@section('content')
    <div class="max-w-2xl" data-aos="fade-up" data-aos-delay="20">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-7">
            <a href="{{ route('tanah.index') }}" class="w-9 h-9 rounded-xl bg-white border border-cream-200/60 flex items-center justify-center text-forest-600 hover:bg-forest-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-lg font-display font-bold text-gray-900">{{ $tanah->exists ? 'Edit Tanah' : 'Tambah Tanah Baru' }}</h1>
                <p class="text-xs text-gray-400">Lengkapi data aset tanah PT Inhutani I</p>
            </div>
        </div>

        <form action="{{ $tanah->exists ? route('tanah.update', $tanah) : route('tanah.store') }}" method="POST" class="space-y-6">
            @csrf
            @if($tanah->exists) @method('PUT') @endif

            {{-- Group: Identitas Tanah --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-emerald-100 to-green-100 text-emerald-600"><i class="bi bi-tag-fill"></i></div>
                    <div>
                        <h3 class="form-group-title">Identitas Tanah</h3>
                        <p class="form-group-desc">Informasi dasar pengenal aset tanah</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">Kode Tanah</label>
                        <input type="text" name="kode_tanah" value="{{ old('kode_tanah',$tanah->kode_tanah) }}" class="input-field @error('kode_tanah') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="TH-001" required>
                        @error('kode_tanah') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Nama Tanah</label>
                        <input type="text" name="nama" value="{{ old('nama',$tanah->nama) }}" class="input-field @error('nama') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="Tanah HGU ..." required>
                        @error('nama') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="input-label">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi',$tanah->lokasi) }}" class="input-field @error('lokasi') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="Desa / Kecamatan, Kabupaten" required>
                    @error('lokasi') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Group: Detail Aset --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-amber-100 to-orange-100 text-amber-600"><i class="bi bi-rulers"></i></div>
                    <div>
                        <h3 class="form-group-title">Detail Aset</h3>
                        <p class="form-group-desc">Spesifikasi dan status terkini tanah</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">Luas (Hektar)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="luas_hektar" value="{{ old('luas_hektar',$tanah->luas_hektar) }}" class="input-field @error('luas_hektar') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror pr-14" placeholder="1.5" required>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-sm font-semibold text-gray-400 pointer-events-none">Ha</span>
                        </div>
                        @error('luas_hektar') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Status</label>
                        <select name="status" class="input-field @error('status') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror">
                            <option value="tersedia" {{ old('status',$tanah->status)==='tersedia'?'selected':'' }}>Tersedia</option>
                            <option value="disewa" {{ old('status',$tanah->status)==='disewa'?'selected':'' }}>Disewa</option>
                        </select>
                        @error('status') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="input-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="input-field @error('deskripsi') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="Deskripsi lokasi tanah, batas-batas, kondisi lahan...">{{ old('deskripsi',$tanah->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary text-sm px-7 py-3 shadow-lg shadow-forest-600/20">
                    <i class="bi bi-check-lg"></i> {{ $tanah->exists ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
                <a href="{{ route('tanah.index') }}" class="btn-outline text-sm px-7 py-3">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
