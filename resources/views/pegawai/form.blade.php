@extends('layouts.app')
@section('title', isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai')

@section('content')
    <div class="max-w-2xl" data-aos="fade-up" data-aos-delay="20">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-7">
            <a href="{{ route('pegawai.index') }}" class="w-9 h-9 rounded-xl bg-white border border-cream-200/60 flex items-center justify-center text-forest-600 hover:bg-forest-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-lg font-display font-bold text-gray-900">{{ isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai Baru' }}</h1>
                <p class="text-xs text-gray-400">Kelola akun pegawai sistem</p>
            </div>
        </div>

        <form action="{{ isset($pegawai) ? route('pegawai.update', $pegawai) : route('pegawai.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($pegawai)) @method('PUT') @endif

            {{-- Group: Data Akun --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600"><i class="bi bi-person-badge-fill"></i></div>
                    <div>
                        <h3 class="form-group-title">Data Akun</h3>
                        <p class="form-group-desc">Informasi login pegawai</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', isset($pegawai) ? $pegawai->name : '') }}" class="input-field @error('name') border-red-300 @enderror" placeholder="Nama pegawai" required>
                        @error('name') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', isset($pegawai) ? $pegawai->email : '') }}" class="input-field @error('email') border-red-300 @enderror" placeholder="email@example.com" required>
                        @error('email') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">{{ isset($pegawai) ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password' }}</label>
                        <input type="password" name="password" class="input-field @error('password') border-red-300 @enderror" placeholder="{{ isset($pegawai) ? 'Kosongkan jika tidak diubah' : 'Min. 6 karakter' }}" {{ isset($pegawai) ? '' : 'required' }}>
                        @error('password') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="input-field" placeholder="Ulangi password">
                    </div>
                </div>
                <div>
                    <label class="input-label">Role</label>
                    <select name="role" class="input-field @error('role') border-red-300 @enderror" required>
                        <option value="petugas" {{ old('role', isset($pegawai) ? $pegawai->role : '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ old('role', isset($pegawai) ? $pegawai->role : '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    <p class="input-hint mt-2 flex items-center gap-1"><i class="bi bi-info-circle text-blue-400"></i> Admin memiliki akses penuh, Petugas hanya akses data operasional</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary shadow-lg shadow-blue-600/15">
                    <i class="bi bi-check-lg"></i> {{ isset($pegawai) ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
                <a href="{{ route('pegawai.index') }}" class="btn-outline">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
