@extends('layouts.app')
@section('title', 'Buat Kontrak Sewa')

@section('content')
    <div class="max-w-3xl" data-aos="fade-up" data-aos-delay="20">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-7">
            <a href="{{ route('kontrak.index') }}" class="w-9 h-9 rounded-xl bg-white border border-cream-200/60 flex items-center justify-center text-forest-600 hover:bg-forest-50 transition-all shadow-sm">
                <i class="bi bi-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-lg font-display font-bold text-gray-900">Buat Kontrak Sewa Baru</h1>
                <p class="text-xs text-gray-400">Isi detail kontrak — cicilan otomatis tergenerate per bulan</p>
            </div>
        </div>

        <form action="{{ route('kontrak.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Group: Data Pihak --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <h3 class="form-group-title">Data Pihak</h3>
                        <p class="form-group-desc">Informasi penyewa dan aset tanah yang disewa</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">No. Kontrak</label>
                        <input type="text" name="no_kontrak" value="{{ old('no_kontrak','KTR-'.date('Ymd').'-') }}" class="input-field @error('no_kontrak') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" required>
                        @error('no_kontrak') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Penyewa</label>
                        <select name="penyewa_id" class="input-field @error('penyewa_id') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" required>
                            <option value="">— Pilih —</option>
                            @foreach($penyewas as $p)
                                <option value="{{ $p->id }}" {{ old('penyewa_id')==$p->id?'selected':'' }}>{{ $p->nama }} {{ $p->perusahaan?'('.$p->perusahaan.')':'' }}</option>
                            @endforeach
                        </select>
                        @error('penyewa_id') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="input-label">Tanah</label>
                    <select name="tanah_id" class="input-field @error('tanah_id') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" required>
                        <option value="">— Pilih Tanah —</option>
                        @foreach($tanahs as $t)
                            <option value="{{ $t->id }}" {{ old('tanah_id')==$t->id?'selected':'' }}>{{ $t->nama }} — {{ $t->lokasi }} ({{ number_format($t->luas_hektar,1) }} Ha)</option>
                        @endforeach
                    </select>
                    @if($tanahs->isEmpty())
                        <p class="input-hint text-amber-600 flex items-center gap-1 mt-2">
                            <i class="bi bi-exclamation-triangle-fill"></i> Tidak ada tanah tersedia. 
                            <a href="{{ route('tanah.create') }}" class="underline font-semibold">Tambah tanah</a>
                        </p>
                    @endif
                    @error('tanah_id') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Group: Periode Kontrak --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-600"><i class="bi bi-calendar-range-fill"></i></div>
                    <div>
                        <h3 class="form-group-title">Periode Kontrak</h3>
                        <p class="form-group-desc">Durasi sewa dan jadwal kontrak</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai',date('Y-m-d')) }}" class="input-field @error('tanggal_mulai') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" required>
                        @error('tanggal_mulai') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="input-field @error('tanggal_selesai') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" required>
                        @error('tanggal_selesai') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Group: Biaya & Cicilan --}}
            <div class="form-group">
                <div class="form-group-header">
                    <div class="form-group-icon bg-gradient-to-br from-amber-100 to-orange-100 text-amber-600"><i class="bi bi-cash-stack"></i></div>
                    <div>
                        <h3 class="form-group-title">Biaya &amp; Cicilan</h3>
                        <p class="form-group-desc">Nilai sewa dan skema pembayaran</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="input-label">Biaya Sewa Total (Rp)</label>
                        <input type="number" name="biaya_sewa_total" value="{{ old('biaya_sewa_total') }}" class="input-field @error('biaya_sewa_total') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="100000000" required>
                        @error('biaya_sewa_total') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="input-label">Jumlah Cicilan</label>
                        <input type="number" name="jumlah_cicilan" id="jumlah_cicilan" value="{{ old('jumlah_cicilan',1) }}" min="1" class="input-field @error('jumlah_cicilan') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" required>
                        <p class="input-hint"><i class="bi bi-magic text-violet-400 mr-1"></i>Terisi otomatis berdasarkan durasi kontrak</p>
                        @error('jumlah_cicilan') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Estimasi --}}
                <div id="estimasiBox" class="hidden bg-violet-50/80 border border-violet-100/60 rounded-xl px-4 py-3.5 flex items-start gap-3">
                    <i class="bi bi-calculator-fill text-violet-500 text-base mt-0.5"></i>
                    <div>
                        <p class="text-xs font-semibold text-violet-700">Estimasi Cicilan per Bulan</p>
                        <p id="estimasiText" class="text-sm font-bold text-violet-800 mt-1"></p>
                    </div>
                </div>

                <div>
                    <label class="input-label">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="input-field @error('keterangan') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="input-hint text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Info Box --}}
            <div class="bg-gradient-to-r from-forest-50 to-emerald-50/70 border border-forest-100/50 rounded-2xl px-5 py-4 flex items-start gap-3 shadow-sm">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-forest-100 to-emerald-100 flex items-center justify-center text-forest-600 shrink-0 shadow-sm"><i class="bi bi-info-circle-fill text-sm"></i></div>
                <div>
                    <p class="text-sm font-bold text-forest-800">Informasi Sistem</p>
                    <p class="text-xs text-forest-600/80 mt-1 leading-relaxed">Cicilan akan otomatis dibuat berdasarkan jumlah bulan kontrak dengan tanggal jatuh tempo setiap bulan. Jumlah cicilan terisi otomatis saat tanggal mulai dan selesai dipilih.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary text-sm px-7 py-3 shadow-lg shadow-violet-600/15">
                    <i class="bi bi-file-earmark-plus"></i> Buat Kontrak
                </button>
                <a href="{{ route('kontrak.index') }}" class="btn-outline text-sm px-7 py-3">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('input[name="tanggal_mulai"]')?.addEventListener('change',calcMonths);
        document.querySelector('input[name="tanggal_selesai"]')?.addEventListener('change',calcMonths);
        function calcMonths(){
            const s=document.querySelector('input[name="tanggal_mulai"]').value,
                  e=document.querySelector('input[name="tanggal_selesai"]').value;
            if(s&&e){
                const a=new Date(s),b=new Date(e);
                let m=(b.getFullYear()-a.getFullYear())*12+(b.getMonth()-a.getMonth());
                if(b.getDate()<a.getDate()) m--;
                if(m>0){
                    document.getElementById('jumlah_cicilan').value=m;
                    calcEstimasi();
                }
            }
        }
        document.querySelector('input[name="biaya_sewa_total"]')?.addEventListener('input',calcEstimasi);
        document.getElementById('jumlah_cicilan')?.addEventListener('input',calcEstimasi);
        function calcEstimasi(){
            const total=parseFloat(document.querySelector('input[name="biaya_sewa_total"]').value)||0;
            const cicilan=parseInt(document.getElementById('jumlah_cicilan').value)||1;
            const box=document.getElementById('estimasiBox');
            const text=document.getElementById('estimasiText');
            if(total>0&&cicilan>0){
                const perBulan=total/cicilan;
                text.textContent='Rp '+perBulan.toLocaleString('id-ID')+' / bulan × '+cicilan+' bulan';
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        }
    </script>
@endsection
