@extends('layouts.app')
@section('title', 'Pegawai')

@section('content')
    <div class="flex items-start sm:items-center justify-between gap-3 flex-col sm:flex-row" data-aos="fade-up">
        <div>
            <h2 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2"><i class="bi bi-people-fill text-forest-600"></i> Pegawai</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola pegawai dan pengguna sistem</p>
        </div>
        <a href="{{ route('pegawai.create') }}" class="btn-primary"><i class="bi bi-person-plus-fill"></i> Tambah Pegawai</a>
    </div>

    {{-- Stats --}}
    @php
        $totalPegawai = App\Models\User::count();
        $petugas = App\Models\User::where('role', 'petugas')->count();
        $admin = App\Models\User::where('role', 'admin')->count();
    @endphp
    <div class="grid grid-cols-3 gap-3" data-aos="fade-up" data-aos-delay="20">
        <div class="rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-blue-700">{{ $totalPegawai }}</p>
            <p class="text-[10px] font-semibold text-blue-600/60 mt-0.5">Total Pegawai</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-emerald-700">{{ $petugas }}</p>
            <p class="text-[10px] font-semibold text-emerald-600/60 mt-0.5">Petugas</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 border border-violet-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-violet-700">{{ $admin }}</p>
            <p class="text-[10px] font-semibold text-violet-600/60 mt-0.5">Admin</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="card-premium glass-card overflow-hidden" data-aos="fade-up" data-aos-delay="40">
        <div class="table-modern-wrap">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th>Bergabung</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawais as $p)
                        <tr>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-xs font-bold text-blue-700 shrink-0 shadow-sm">
                                        {{ strtoupper(substr($p->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $p->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-gray-500">{{ $p->email }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $p->role === 'admin' ? 'badge-tersedia' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($p->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs text-gray-500">{{ $p->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="text-center">
                                <div class="flex gap-1.5 justify-center">
                                    <a href="{{ route('pegawai.edit', $p) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-forest-50 text-forest-700 font-semibold text-[10px] transition-all duration-300 hover:bg-forest-600 hover:text-white active:scale-95 border border-forest-100/30">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    @if($p->id !== auth()->id())
                                        <form action="{{ route('pegawai.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pegawai {{ $p->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-red-50 text-red-700 font-semibold text-[10px] transition-all duration-300 hover:bg-red-600 hover:text-white active:scale-95 border border-red-100/30">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <i class="bi bi-people text-4xl text-cream-300 mb-3 block"></i>
                                <p class="font-display font-bold text-gray-400 text-sm">Belum ada pegawai</p>
                                <p class="text-xs text-gray-300 mt-1">Tambah pegawai untuk mengelola pengguna sistem</p>
                                <a href="{{ route('pegawai.create') }}" class="btn-primary mt-4 inline-flex"><i class="bi bi-person-plus-fill"></i> Tambah Pegawai</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
