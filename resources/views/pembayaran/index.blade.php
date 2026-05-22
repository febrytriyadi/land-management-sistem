@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')
    <div class="flex items-start sm:items-center justify-between gap-3 flex-col sm:flex-row" data-aos="fade-up">
        <div>
            <h2 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2"><i class="bi bi-wallet-fill text-forest-600"></i> Pembayaran</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola pembayaran sewa tanah</p>
        </div>
        <form action="{{ route('pembayaran.notifikasi-semua') }}" method="POST">
            @csrf
            <button type="submit" class="btn-warning text-xs"><i class="bi bi-send-fill"></i> Kirim Semua Notifikasi</button>
        </form>
    </div>

    <!-- Stats Cards -->
    @php
        $totalBelum = App\Models\Pembayaran::where('status','belum_dibayar')->count();
        $totalLunas = App\Models\Pembayaran::where('status','lunas')->count();
        $totalTerlambat = App\Models\Pembayaran::where('status','terlambat')->count();
    @endphp
    <div class="grid grid-cols-3 gap-3" data-aos="fade-up" data-aos-delay="20">
        <div class="rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-amber-700">{{ $totalBelum }}</p>
            <p class="text-[10px] font-semibold text-amber-600/60 mt-0.5">Belum Dibayar</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-emerald-700">{{ $totalLunas }}</p>
            <p class="text-[10px] font-semibold text-emerald-600/60 mt-0.5">Lunas</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-red-50 to-red-100 border border-red-200/40 p-4 text-center shadow-sm">
            <p class="text-xl font-display font-extrabold text-red-700">{{ $totalTerlambat }}</p>
            <p class="text-[10px] font-semibold text-red-600/60 mt-0.5">Terlambat</p>
        </div>
    </div>

    <div class="card-premium glass-card overflow-hidden" data-aos="fade-up" data-aos-delay="40">
        <div class="table-modern-wrap">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kontrak</th>
                        <th>Tanah</th>
                        <th>Penyewa</th>
                        <th class="text-center">Cicilan</th>
                        <th class="text-right">Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $p)
                        <tr class="{{ $p->status==='terlambat' ? 'bg-red-50/30' : ($p->status==='lunas' ? 'bg-emerald-50/20' : '') }}">
                            <td>
                                <span class="font-bold text-gray-800 text-xs">{{ $p->kontrak->no_kontrak }}</span>
                            </td>
                            <td>
                                <span class="text-xs font-medium">{{ $p->kontrak->tanah->nama }}</span>
                                <span class="block text-[10px] text-gray-400">{{ $p->kontrak->tanah->kode_tanah }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-forest-50 flex items-center justify-center text-[9px] font-bold text-forest-600 shrink-0">
                                        {{ strtoupper(substr($p->kontrak->penyewa->nama, 0, 1)) }}
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $p->kontrak->penyewa->nama }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <div class="w-7 h-7 rounded-lg bg-forest-50 flex items-center justify-center">
                                        <span class="font-bold text-forest-700 text-[11px]">{{ $p->cicilan_ke }}</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400">/ {{ $p->kontrak->jumlah_cicilan }}</span>
                                </div>
                            </td>
                            <td class="text-right">
                                <span class="font-bold text-gray-900 text-sm">Rp {{ number_format($p->jumlah,0,',','.') }}</span>
                            </td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium {{ $p->status==='terlambat' ? 'text-red-600' : 'text-gray-700' }}">
                                        {{ $p->tanggal_jatuh_tempo->format('d M Y') }}
                                    </span>
                                    @if($p->status==='terlambat')
                                        <span class="text-[10px] text-red-500 font-semibold flex items-center gap-1 mt-0.5">
                                            <i class="bi bi-exclamation-triangle-fill"></i> Terlambat {{ $p->terlambat }} hari
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $p->status }}">{{ str_replace('_',' ',ucfirst($p->status)) }}</span>
                            </td>
                            <td>
                                <div class="flex gap-1.5 justify-center">
                                    <!-- Tombol Edit -->
                                    <button type="button"
                                        x-data
                                        x-on:click.prevent="$dispatch('open-modal', {{ $p->id }})"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-blue-50 text-blue-700 font-semibold text-[10px] transition-all duration-300 hover:bg-blue-600 hover:text-white active:scale-95 border border-blue-200/40">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </button>
                                    @if($p->status!=='lunas')
                                        <button type="button"
                                            x-data
                                            x-on:click.prevent="$dispatch('open-bayar-modal', {{ $p->id }})"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-semibold text-[10px] transition-all duration-300 hover:bg-emerald-600 hover:text-white active:scale-95 border border-emerald-200/40">
                                            <i class="bi bi-check-lg"></i> Bayar
                                        </button>
                                    @else
                                        <a href="{{ route('pembayaran.download-bukti',$p) }}"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-semibold text-[10px] transition-all duration-300 hover:bg-emerald-600 hover:text-white active:scale-95 border border-emerald-200/40">
                                            <i class="bi bi-paperclip"></i> Bukti
                                        </a>
                                    @endif
                                    <a href="{{ route('pembayaran.invoice',$p) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 font-semibold text-[10px] transition-all duration-300 hover:bg-indigo-600 hover:text-white active:scale-95 border border-indigo-200/40">
                                        <i class="bi bi-file-pdf-fill"></i> Invoice
                                    </a>
                                    <form action="{{ route('pembayaran.notifikasi',$p) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-forest-50 text-forest-700 font-semibold text-[10px] transition-all duration-300 hover:bg-forest-600 hover:text-white active:scale-95 border border-forest-100/30">
                                            <i class="bi bi-envelope-fill"></i> Email
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-16">
                                <i class="bi bi-wallet text-4xl text-cream-300 mb-3 block"></i>
                                <p class="font-display font-bold text-gray-400 text-sm">Belum ada data pembayaran</p>
                                <p class="text-xs text-gray-300 mt-1">Pembayaran otomatis terbuat saat kontrak dibuat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit Pembayaran -->
    <div x-data="{ open: false, pembayaran: null }"
         x-on:open-modal.window="pembayaran = {{ $pembayarans->toJson() }}.find(p => p.id === $event.detail); open = true"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-transition.opacity>
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" x-on:click="open = false"></div>
        <!-- Modal Card -->
        <div class="relative w-full max-w-lg animate-scale-in" x-on:click.outside="open = false">
            <div class="card-premium glass-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-display font-bold text-gray-900 flex items-center gap-2">
                        <i class="bi bi-pencil-fill text-blue-600"></i> Edit Pembayaran
                    </h3>
                    <button x-on:click="open = false" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 text-sm transition-all">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <template x-if="pembayaran">
                    <form :action="`{{ route('pembayaran.update', '') }}/${pembayaran.id}`" method="POST">
                        @csrf @method('PUT')

                        <!-- Info Kontrak -->
                        <div class="bg-forest-50/50 rounded-xl p-3 mb-4 text-xs text-gray-600">
                            <span class="font-bold" x-text="pembayaran.kontrak?.no_kontrak || '-'"></span> —
                            <span x-text="pembayaran.kontrak?.tanah?.nama || '-'"></span> —
                            Cicilan <span x-text="pembayaran.cicilan_ke"></span>/<span x-text="pembayaran.kontrak?.jumlah_cicilan || '?'"></span>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Jumlah -->
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1">Jumlah (Rp)</label>
                                <input type="number" name="jumlah" step="0.01" min="0" required
                                    x-model="pembayaran.jumlah"
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1">Status</label>
                                <select name="status"
                                    x-model="pembayaran.status"
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                                    <option value="belum_dibayar">Belum Dibayar</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="terlambat">Terlambat</option>
                                </select>
                            </div>

                            <!-- Jatuh Tempo -->
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1">Jatuh Tempo</label>
                                <input type="date" name="tanggal_jatuh_tempo"
                                    x-model="pembayaran.tanggal_jatuh_tempo"
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                            </div>

                            <!-- Tanggal Bayar -->
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar"
                                    x-model="pembayaran.tanggal_bayar"
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                                <p class="text-[9px] text-gray-400 mt-0.5">Kosongkan jika belum bayar</p>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1">Metode Bayar</label>
                                <input type="text" name="metode_pembayaran"
                                    x-model="pembayaran.metode_pembayaran"
                                    placeholder="Transfer Bank, Tunai, dll"
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mt-3">
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Keterangan</label>
                            <textarea name="keterangan" rows="2"
                                x-model="pembayaran.keterangan"
                                placeholder="Opsional"
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none resize-none"></textarea>
                        </div>

                        <div class="flex gap-2 justify-end mt-5">
                            <button type="button" x-on:click="open = false"
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-all">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-forest-600 hover:bg-forest-700 transition-all shadow-sm">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    <!-- Modal Bayar Pembayaran -->
    <div x-data="{ open: false, pembayaran: null, fileSelected: false }"
         x-on:open-bayar-modal.window="pembayaran = {{ $pembayarans->toJson() }}.find(p => p.id === $event.detail); open = true; fileSelected = false"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-transition.opacity>
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" x-on:click="open = false"></div>
        <div class="relative w-full max-w-md animate-scale-in" x-on:click.outside="open = false">
            <div class="card-premium glass-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-display font-bold text-gray-900 flex items-center gap-2">
                        <i class="bi bi-check-circle-fill text-emerald-600"></i> Konfirmasi Pembayaran
                    </h3>
                    <button x-on:click="open = false" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 text-sm transition-all">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <template x-if="pembayaran">
                    <form :action="`{{ route('pembayaran.bayar', '') }}/${pembayaran.id}`" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <!-- Info -->
                        <div class="bg-emerald-50/50 rounded-xl p-3 mb-4 text-xs text-gray-600">
                            <span class="font-bold" x-text="pembayaran.kontrak?.no_kontrak || '-'"></span> —
                            <span x-text="pembayaran.kontrak?.tanah?.nama || '-'"></span> —
                            Cicilan <span x-text="pembayaran.cicilan_ke"></span>/<span x-text="pembayaran.kontrak?.jumlah_cicilan || '?'"></span>
                            <br>
                            Jumlah: <span class="font-bold text-emerald-700" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(pembayaran.jumlah)"></span>
                        </div>

                        <!-- Step 1: Download Invoice -->
                        <div class="bg-blue-50/60 rounded-xl p-3 mb-3 border border-blue-100">
                            <p class="text-[11px] font-semibold text-blue-800 mb-2 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-blue-600 text-white text-[9px] font-bold flex items-center justify-center shrink-0">1</span>
                                Download Invoice untuk Penyewa
                            </p>
                            <a :href="`{{ route('pembayaran.invoice', '') }}/${pembayaran.id}`" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-all shadow-sm">
                                <i class="bi bi-file-pdf-fill"></i> Download Invoice
                            </a>
                            <p class="text-[10px] text-blue-500 mt-1.5">Kirim invoice ini ke penyewa sebagai tagihan</p>
                        </div>

                        <!-- Step 2: Upload Bukti -->
                        <div class="bg-amber-50/60 rounded-xl p-3 mb-3 border border-amber-100">
                            <p class="text-[11px] font-semibold text-amber-800 mb-2 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-amber-600 text-white text-[9px] font-bold flex items-center justify-center shrink-0">2</span>
                                Upload Bukti Pembayaran dari Penyewa
                            </p>
                            <div class="relative">
                                <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required
                                    x-on:change="fileSelected = $event.target.files.length > 0"
                                    class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 transition-all cursor-pointer">
                            </div>
                            <p class="text-[10px] text-amber-500 mt-1.5">Format: JPG, PNG, atau PDF. Maks 2MB</p>
                        </div>

                        <!-- Step 3: Metode & Tanggal -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1">Metode Bayar</label>
                                <select name="metode_pembayaran" required
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                                    <option value="Transfer Bank">Transfer Bank</option>
                                    <option value="Tunai">Tunai</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="Giro">Giro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1">Tgl Bayar</label>
                                <input type="date" name="tanggal_bayar" required
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Keterangan (opsional)</label>
                            <textarea name="keterangan" rows="2" placeholder="Catatan tambahan..."
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none resize-none"></textarea>
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            x-bind:disabled="!fileSelected"
                            x-bind:class="fileSelected ? 'bg-emerald-600 hover:bg-emerald-700 cursor-pointer shadow-sm' : 'bg-gray-300 cursor-not-allowed'"
                            class="w-full px-4 py-3 rounded-xl text-xs font-bold text-white transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-check-lg"></i>
                            <span x-text="fileSelected ? 'Konfirmasi Pembayaran' : 'Upload bukti pembayaran terlebih dahulu'"></span>
                        </button>
                    </form>
                </template>
            </div>
        </div>
    </div>
@endsection
