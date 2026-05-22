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
                                <span class="badge badge-{{ $p->status }} whitespace-nowrap">{{ str_replace('_',' ',ucfirst($p->status)) }}</span>
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="flex gap-1 justify-center items-center">
                                    <!-- Edit -->
                                    <button type="button"
                                        onclick="showModal('edit', this.dataset)"
                                        data-id="{{ $p->id }}"
                                        data-kontrak="{{ $p->kontrak->no_kontrak }}"
                                        data-tanah="{{ $p->kontrak->tanah->nama }}"
                                        data-cicilan="{{ $p->cicilan_ke }}"
                                        data-total="{{ $p->kontrak->jumlah_cicilan }}"
                                        data-jumlah="{{ $p->jumlah }}"
                                        data-jatuh="{{ $p->tanggal_jatuh_tempo }}"
                                        data-status="{{ $p->status }}"
                                        data-tglbayar="{{ $p->tanggal_bayar ?? '' }}"
                                        data-metode="{{ $p->metode_pembayaran ?? '' }}"
                                        data-keterangan="{{ $p->keterangan ?? '' }}"
                                        class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center text-xs border border-blue-200/40 shrink-0"
                                        title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    @if($p->status!=='lunas')
                                        <!-- Bayar -->
                                        <button type="button"
                                            onclick="showModal('bayar', this.dataset)"
                                            data-id="{{ $p->id }}"
                                            data-kontrak="{{ $p->kontrak->no_kontrak }}"
                                            data-tanah="{{ $p->kontrak->tanah->nama }}"
                                            data-cicilan="{{ $p->cicilan_ke }}"
                                            data-total="{{ $p->kontrak->jumlah_cicilan }}"
                                            data-jumlah="{{ $p->jumlah }}"
                                            class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center text-xs border border-emerald-200/40 shrink-0"
                                            title="Bayar">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    @else
                                        <!-- Bukti -->
                                        <a href="{{ route('pembayaran.download-bukti',$p) }}"
                                            class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center text-xs border border-emerald-200/40 shrink-0"
                                            title="Download Bukti">
                                            <i class="bi bi-paperclip"></i>
                                        </a>
                                    @endif

                                    <!-- Invoice -->
                                    <a href="{{ route('pembayaran.invoice',$p) }}" target="_blank"
                                        class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center text-xs border border-indigo-200/40 shrink-0"
                                        title="Invoice PDF">
                                        <i class="bi bi-file-pdf-fill"></i>
                                    </a>

                                    <!-- Email -->
                                    <form action="{{ route('pembayaran.notifikasi',$p) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="w-7 h-7 rounded-lg bg-forest-50 text-forest-700 hover:bg-forest-600 hover:text-white transition-all flex items-center justify-center text-xs border border-forest-100/30 shrink-0"
                                            title="Kirim Email">
                                            <i class="bi bi-envelope-fill"></i>
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

    <!-- Modal Edit (JS) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" style="display:none">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('edit')"></div>
        <div class="relative w-full max-w-lg animate-scale-in">
            <div class="card-premium glass-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-display font-bold text-gray-900 flex items-center gap-2">
                        <i class="bi bi-pencil-fill text-blue-600"></i> Edit Pembayaran
                    </h3>
                    <button onclick="closeModal('edit')" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 text-sm transition-all">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div id="editInfo" class="bg-forest-50/50 rounded-xl p-3 mb-4 text-xs text-gray-600"></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Jumlah (Rp)</label>
                            <input type="number" name="jumlah" id="editJumlah" step="0.01" min="0" required class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Status</label>
                            <select name="status" id="editStatus" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                                <option value="belum_dibayar">Belum Dibayar</option>
                                <option value="lunas">Lunas</option>
                                <option value="terlambat">Terlambat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Jatuh Tempo</label>
                            <input type="date" name="tanggal_jatuh_tempo" id="editJatuhTempo" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Tanggal Bayar</label>
                            <input type="date" name="tanggal_bayar" id="editTglBayar" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                            <p class="text-[9px] text-gray-400 mt-0.5">Kosongkan jika belum bayar</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Metode Bayar</label>
                            <input type="text" name="metode_pembayaran" id="editMetode" placeholder="Transfer Bank, Tunai, dll" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1">Keterangan</label>
                        <textarea name="keterangan" id="editKeterangan" rows="2" placeholder="Opsional" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none resize-none"></textarea>
                    </div>
                    <div class="flex gap-2 justify-end mt-5">
                        <button type="button" onclick="closeModal('edit')" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-all">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-forest-600 hover:bg-forest-700 transition-all shadow-sm"><i class="bi bi-check-lg"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Bayar (JS) -->
    <div id="bayarModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" style="display:none">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('bayar')"></div>
        <div class="relative w-full max-w-md animate-scale-in">
            <div class="card-premium glass-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-display font-bold text-gray-900 flex items-center gap-2">
                        <i class="bi bi-check-circle-fill text-emerald-600"></i> Konfirmasi Pembayaran
                    </h3>
                    <button onclick="closeModal('bayar')" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 text-sm transition-all">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form id="bayarForm" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div id="bayarInfo" class="bg-emerald-50/50 rounded-xl p-3 mb-4 text-xs text-gray-600"></div>

                    <div class="bg-blue-50/60 rounded-xl p-3 mb-3 border border-blue-100">
                        <p class="text-[11px] font-semibold text-blue-800 mb-2 flex items-center gap-1.5">
                            <span class="w-5 h-5 rounded-full bg-blue-600 text-white text-[9px] font-bold flex items-center justify-center shrink-0">1</span>
                            Download Invoice untuk Penyewa
                        </p>
                        <a id="bayarInvoiceLink" href="#" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-all shadow-sm">
                            <i class="bi bi-file-pdf-fill"></i> Download Invoice
                        </a>
                        <p class="text-[10px] text-blue-500 mt-1.5">Kirim invoice ini ke penyewa sebagai tagihan</p>
                    </div>

                    <div class="bg-amber-50/60 rounded-xl p-3 mb-3 border border-amber-100">
                        <p class="text-[11px] font-semibold text-amber-800 mb-2 flex items-center gap-1.5">
                            <span class="w-5 h-5 rounded-full bg-amber-600 text-white text-[9px] font-bold flex items-center justify-center shrink-0">2</span>
                            Upload Bukti Pembayaran dari Penyewa
                        </p>
                        <input type="file" name="bukti_pembayaran" id="bayarBukti" accept=".jpg,.jpeg,.png,.pdf" required
                            onchange="document.getElementById('bayarSubmit').disabled = !this.files.length; document.getElementById('bayarSubmitText').textContent = this.files.length ? 'Konfirmasi Pembayaran' : 'Upload bukti pembayaran terlebih dahulu';"
                            class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 transition-all cursor-pointer">
                        <p class="text-[10px] text-amber-500 mt-1.5">Format: JPG, PNG, atau PDF. Maks 2MB</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Metode Bayar</label>
                            <select name="metode_pembayaran" required class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="Tunai">Tunai</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Giro">Giro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1">Tgl Bayar</label>
                            <input type="date" name="tanggal_bayar" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1">Keterangan (opsional)</label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan tambahan..." class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-forest-500/20 focus:border-forest-500 outline-none resize-none"></textarea>
                    </div>

                    <button type="submit" id="bayarSubmit" disabled
                        class="w-full px-4 py-3 rounded-xl text-xs font-bold text-white bg-gray-300 cursor-not-allowed transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-check-lg"></i>
                        <span id="bayarSubmitText">Upload bukti pembayaran terlebih dahulu</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function showModal(type, d) {
        if (type === 'edit') {
            document.getElementById('editForm').action = '/pembayaran/' + d.id;
            document.getElementById('editInfo').innerHTML = '<span class="font-bold">' + d.kontrak + '</span> — ' + d.tanah + ' — Cicilan ' + d.cicilan + '/' + d.total;
            document.getElementById('editJumlah').value = d.jumlah;
            document.getElementById('editStatus').value = d.status;
            document.getElementById('editJatuhTempo').value = d.jatuh;
            document.getElementById('editTglBayar').value = d.tglbayar || '';
            document.getElementById('editMetode').value = d.metode || '';
            document.getElementById('editKeterangan').value = d.keterangan || '';
            document.getElementById('editModal').style.display = 'flex';
        } else if (type === 'bayar') {
            document.getElementById('bayarForm').action = '/pembayaran/' + d.id + '/bayar';
            document.getElementById('bayarInfo').innerHTML = '<span class="font-bold">' + d.kontrak + '</span> — ' + d.tanah + ' — Cicilan ' + d.cicilan + '/' + d.total + '<br>Jumlah: <span class="font-bold text-emerald-700">Rp ' + new Intl.NumberFormat('id-ID').format(parseFloat(d.jumlah)) + '</span>';
            document.getElementById('bayarInvoiceLink').href = '/pembayaran/' + d.id + '/invoice';
            document.getElementById('bayarBukti').value = '';
            document.getElementById('bayarSubmit').disabled = true;
            document.getElementById('bayarSubmitText').textContent = 'Upload bukti pembayaran terlebih dahulu';
            document.getElementById('bayarModal').style.display = 'flex';
        }
    }
    function closeModal(type) {
        document.getElementById(type + 'Modal').style.display = 'none';
    }

    // Click overlay to close
    document.addEventListener('click', function(e) {
        if (e.target.id === 'editModal') closeModal('edit');
        if (e.target.id === 'bayarModal') closeModal('bayar');
    });
    </script>
@endsection
