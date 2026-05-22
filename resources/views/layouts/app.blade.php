<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — PT Inhutani I</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: { 50: '#FDFBF7', 100: '#FAF5EB', 200: '#F5EDD8', 300: '#EDE0BD', 400: '#E0CD9E' },
                        forest: { 50: '#EEF5EC', 100: '#D8E8D0', 200: '#B0D09E', 300: '#82B36A', 400: '#5C9A42', 500: '#3D7A2A', 600: '#2D5A27', 700: '#1F3F1C', 800: '#132B11' },
                    },
                    fontFamily: { display: ['Plus Jakarta Sans', 'Inter', 'sans-serif'], sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        * { transition: background-color .2s, color .2s, border-color .2s, box-shadow .2s; }
        body { font-family: 'Inter', sans-serif; background: #FAF5EB; }
        .font-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        @keyframes slideDown { 0% { opacity:0; transform:translateY(-10px) } 100% { opacity:1; transform:translateY(0) } }
        @keyframes scaleIn { 0% { opacity:0; transform:scale(0.9) } 100% { opacity:1; transform:scale(1) } }
        @keyframes fadeIn { 0% { opacity:0 } 100% { opacity:1 } }
        .animate-slide-down { animation: slideDown .3s ease-out; }
        .animate-scale-in { animation: scaleIn .3s cubic-bezier(.34,1.56,.64,1); }
        
        /* Sidebar */
        .sb { background: linear-gradient(175deg, #1F3F1C 0%, #2D5A27 50%, #1F3F1C 100%); }
        .sb-link { display: flex; align-items: center; gap: 0.75rem; width: 100%; padding: 0.625rem 0.875rem; font-size: 0.75rem; font-weight: 500; border-radius: 0.5rem; transition: all 0.2s; }
        .sb-link i { font-size: 1rem; width: 1.25rem; text-align: center; flex-shrink: 0; }
        .sb-link:hover { background: rgba(255,255,255,0.06); }
        .sb-link.active { background: rgba(255,255,255,0.1); box-shadow: inset 2px 0 0 #82C341; color: white; }
        .sb-link:not(.active) { color: rgba(245,237,189,0.6); }
        .sb-link:not(.active):hover { color: #F5EDD8; }
        .sb-label { font-size: 0.5625rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.15em; color: rgba(245,237,189,0.2); padding: 1rem 0.875rem 0.375rem; display: block; }
        
        /* Cards */
        .card, .card-premium { border-radius: 1.25rem; }
        .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.5); box-shadow: 0 4px 24px rgba(0,0,0,0.04); }
        .card-premium:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -8px rgba(45,90,39,0.12); }

        /* Buttons */
        .btn-primary { display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(to right, #2D5A27, #3D7A2A); color: white; font-weight: 700; font-size: 0.875rem; transition: all 0.3s; border-radius: 0.75rem; padding: 0.75rem 1.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(45,90,39,0.25); }
        .btn-primary:active { transform: scale(0.97); }
        .btn-outline { display: inline-flex; align-items: center; gap: 0.5rem; border: 2px solid rgba(45,90,39,0.15); color: #1F3F1C; font-weight: 600; font-size: 0.875rem; transition: all 0.3s; border-radius: 0.75rem; padding: 0.75rem 1.75rem; }
        .btn-outline:hover { background: #2D5A27; color: white; transform: translateY(-2px); border-color: #2D5A27; }
        .btn-outline:active { transform: scale(0.97); }
        .btn-success { display: inline-flex; align-items: center; gap: 0.375rem; background: linear-gradient(to right, #059669, #10B981); color: white; font-weight: 600; font-size: 0.75rem; transition: all 0.3s; border-radius: 0.5rem; padding: 0.5rem 0.875rem; }
        .btn-success:hover { transform: translateY(-1px); }
        .btn-success:active { transform: scale(0.97); }
        .btn-warning { display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(to right, #F59E0B, #F97316); color: white; font-weight: 600; font-size: 0.75rem; transition: all 0.3s; border-radius: 0.75rem; padding: 0.625rem 1rem; }
        .btn-warning:hover { transform: translateY(-1px); }
        .btn-warning:active { transform: scale(0.97); }

        /* Input Fields — Clean & Modern */
        .input-field { width: 100%; font-size: 0.875rem; transition: all 0.2s; background: white; border-radius: 0.75rem; padding: 0.875rem 1rem; border: 1px solid rgba(237,221,192,0.7); outline: none; color: #1F2937; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .input-field::placeholder { color: #D1D5DB; }
        .input-field:focus { border-color: #2D5A27; box-shadow: 0 0 0 3px rgba(45,90,39,0.1); }
        select.input-field { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%239CA3AF'%3E%3Cpath d='M8 11L3 6h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 14px; padding-right: 2.5rem; }
        textarea.input-field { resize: none; }
        .input-label { display: block; font-size: 0.75rem; font-weight: 600; color: #4B5563; margin-bottom: 0.5rem; }
        .input-hint { font-size: 0.6875rem; color: #9CA3AF; margin-top: 0.375rem; }
        
        /* Form Groups */
        .form-group { background: white; border: 1px solid rgba(237,221,192,0.5); border-radius: 1rem; padding: 1.5rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .form-group > * + * { margin-top: 1.25rem; }
        .form-group-header { display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(237,221,192,0.5); }
        .form-group-icon { width: 2.25rem; height: 2.25rem; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05); }
        .form-group-title { font-size: 0.875rem; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; font-weight: 700; color: #1F2937; }
        .form-group-desc { font-size: 0.6875rem; color: #9CA3AF; margin-top: 0.125rem; }
        
        /* Badge */
        .badge { display: inline-flex; align-items: center; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 9999px; font-size: 0.625rem; padding: 0.125rem 0.625rem; }
        .badge-tersedia,.badge-aktif,.badge-lunas { background: #D1FAE5; color: #065F46; }
        .badge-disewa { background: #DBEAFE; color: #1E40AF; }
        .badge-selesai { background: #F3F4F6; color: #4B5563; }
        .badge-dibatalkan { background: #FEE2E2; color: #B91C1C; }
        .badge-belum_dibayar { background: #FEF3C7; color: #92400E; }
        .badge-terlambat { background: #FEE2E2; color: #B91C1C; }

        /* Tables */
        .table-modern-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 0.75rem; border: 1px solid rgba(237,221,192,0.4); }
        .table-modern-wrap::-webkit-scrollbar { height: 4px; }
        .table-modern-wrap::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .table-modern-wrap::-webkit-scrollbar-thumb { background: #2D5A27; border-radius: 4px; }
        .table-modern { width: 100%; border-collapse: collapse; }
        .table-modern thead { background: linear-gradient(to right, #2D5A27, #1F3F1C); }
        .table-modern thead th { padding: 0.875rem 1rem; text-align: left; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: rgba(255,255,255,0.9); border-bottom: 1px solid rgba(45,90,39,0.3); }
        .table-modern thead th:first-child { border-radius: 0.75rem 0 0 0; }
        .table-modern thead th:last-child { border-radius: 0 0.75rem 0 0; }
        .table-modern tbody tr { border-bottom: 1px solid rgba(237,221,192,0.2); transition: all 0.15s; }
        .table-modern tbody tr:last-child { border-bottom: none; }
        .table-modern tbody tr:nth-child(even) { background: rgba(250,245,235,0.3); }
        .table-modern tbody tr:hover { background: rgba(238,245,236,0.6); }
        .table-modern tbody td { padding: 0.75rem 1rem; font-size: 0.75rem; color: #4B5563; }

        ::-webkit-scrollbar { width: 3px; }
        ::-webkit-scrollbar-thumb { background: rgba(45,90,39,0.12); border-radius: 10px; }
        @media (max-width: 1023px) { .mw { margin-left: 0 !important; } }
    </style>
</head>
<body x-data="{ 
    open: window.innerWidth >= 1024,
    mobile: window.innerWidth < 1024
}" x-init="window.addEventListener('resize', () => { mobile = window.innerWidth < 1024; if (mobile) open = false; else open = true; })" class="min-h-screen">

    <!-- Backdrop -->
    <div x-show="open" x-transition:enter="fade-in" class="fixed inset-0 z-30 bg-black/15 backdrop-blur-sm lg:hidden" @@click="open = false"></div>

    <!-- SIDEBAR -->
    <aside x-show="open" 
           x-transition:enter="transition-all duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition-all duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
           class="fixed top-0 left-0 z-40 h-screen w-60 sb flex flex-col overflow-hidden">

        <!-- Brand -->
        <div class="px-4 pt-5 pb-3 border-b border-white/[0.05] shrink-0">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('logo-inhutani.jpg') }}" alt="" class="w-9 h-9 rounded-lg object-cover ring-1 ring-white/10 shrink-0">
                <div>
                    <h1 class="text-white font-display font-bold text-sm">Inhutani I</h1>
                    <p class="text-cream-300/20 text-[8px] font-bold uppercase tracking-[0.2em]">Land Management</p>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <div class="flex-1 overflow-y-auto px-2.5 py-3">
            <p class="sb-label">Menu</p>
            <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active text-white' : 'text-cream-200/60 hover:text-cream-200' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <p class="sb-label">Master Data</p>
            <a href="{{ route('tanah.index') }}" class="sb-link {{ request()->routeIs('tanah.*') ? 'active text-white' : 'text-cream-200/60 hover:text-cream-200' }}">
                <i class="bi bi-tree-fill"></i>
                <span>Data Tanah</span>
            </a>
            <a href="{{ route('penyewa.index') }}" class="sb-link {{ request()->routeIs('penyewa.*') ? 'active text-white' : 'text-cream-200/60 hover:text-cream-200' }}">
                <i class="bi bi-people-fill"></i>
                <span>Penyewa</span>
            </a>

            <p class="sb-label">Transaksi</p>
            <a href="{{ route('kontrak.index') }}" class="sb-link {{ request()->routeIs('kontrak.*') ? 'active text-white' : 'text-cream-200/60 hover:text-cream-200' }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Kontrak Sewa</span>
            </a>
            <a href="{{ route('pembayaran.index') }}" class="sb-link {{ request()->routeIs('pembayaran.*') ? 'active text-white' : 'text-cream-200/60 hover:text-cream-200' }}">
                <i class="bi bi-wallet-fill"></i>
                <span>Pembayaran</span>
            </a>

            <p class="sb-label">Pengaturan</p>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('pegawai.index') }}" class="sb-link {{ request()->routeIs('pegawai.*') ? 'active text-white' : 'text-cream-200/60 hover:text-cream-200' }}">
                <i class="bi bi-people-fill"></i>
                <span>Pegawai</span>
            </a>
            @endif
            <button onclick="document.getElementById('notifModal').classList.remove('hidden')" 
                    class="sb-link w-full text-cream-200/60 hover:text-cream-200">
                <i class="bi bi-bell-fill"></i>
                <span class="flex-1 text-left">Notifikasi</span>
                <span class="w-1.5 h-1.5 rounded-full bg-lime-400"></span>
            </button>
        </div>

        <!-- User -->
        <div class="p-3 border-t border-white/[0.05] shrink-0">
            <div class="flex items-center gap-2.5 px-1 py-1.5">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-xs font-bold text-cream-200/70 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-cream-200/80 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <div class="flex items-center gap-1.5">
                        <span class="w-1 h-1 rounded-full bg-emerald-400"></span>
                        <span class="text-[8px] text-cream-300/30 font-medium">Online</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-7 h-7 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-cream-300/30 hover:text-cream-200/60 transition-all" title="Keluar">
                        <i class="bi bi-box-arrow-right text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="mw min-h-screen flex flex-col" :style="open && !mobile ? 'margin-left: 15rem' : 'margin-left: 0'" style="transition: margin-left .3s cubic-bezier(.16,1,.3,1)">

        <!-- TOPBAR -->
        <header class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-cream-100/40">
            <div class="flex items-center justify-between px-5 py-2.5">
                <div class="flex items-center gap-3">
                    <button @@click="open = !open" class="w-8 h-8 rounded-lg hover:bg-cream-100 flex items-center justify-center transition-all {{ request()->routeIs('dashboard')?'':'bg-cream-100' }}">
                        <svg class="w-[16px] h-[16px] text-forest-700" :class="open ? 'rotate-90' : ''" style="transition: transform .2s" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h2 class="text-sm font-display font-bold text-gray-900">@yield('title')</h2>
                        <p class="text-[9px] text-cream-400 font-medium">PT Inhutani I — Pengelolaan Aset Tanah</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="hidden sm:flex items-center gap-1.5 px-2.5 py-1 bg-forest-50 rounded-lg border border-forest-100/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span class="text-[9px] font-bold text-forest-700 tracking-wider">INHUTANI I</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit" class="text-[10px] text-cream-400 hover:text-red-500 font-medium transition-colors">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-5 space-y-4">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="flex items-center gap-3 p-3.5 bg-gradient-to-r from-emerald-50 to-green-50/80 border border-emerald-200/50 rounded-xl animate-slide-down">
                    <i class="bi bi-check-circle-fill text-emerald-500"></i>
                    <p class="text-xs font-semibold text-emerald-800 flex-1">{{ session('success') }}</p>
                    <button @@click="show = false" class="w-6 h-6 rounded-lg bg-white/60 hover:bg-white flex items-center justify-center text-emerald-400 hover:text-emerald-600 text-xs">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="flex items-center gap-3 p-3.5 bg-gradient-to-r from-red-50 to-rose-50/80 border border-red-200/50 rounded-xl animate-slide-down">
                    <i class="bi bi-x-circle-fill text-red-500"></i>
                    <p class="text-xs font-semibold text-red-800 flex-1">{{ session('error') }}</p>
                    <button @@click="show = false" class="w-6 h-6 rounded-lg bg-white/60 hover:bg-white flex items-center justify-center text-red-400 hover:text-red-600 text-xs">&times;</button>
                </div>
            @endif
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="px-5 pb-4 mt-auto">
            <div class="border-t border-cream-200/30 pt-3 flex items-center justify-between">
                <p class="text-[10px] text-cream-400">© {{ date('Y') }} PT Inhutani I</p>
                <p class="text-[10px] text-cream-400">v3.0</p>
            </div>
        </footer>
    </div>

    <!-- NOTIF MODAL -->
    <div id="notifModal" class="fixed inset-0 z-50 hidden bg-black/15 backdrop-blur-sm" onclick="if(event.target===this)document.getElementById('notifModal').classList.add('hidden')">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white/90 backdrop-blur-2xl border border-white/50 rounded-2xl shadow-2xl w-full max-w-sm p-6 animate-scale-in" onclick="event.stopPropagation()">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-amber-600"><i class="bi bi-bell-fill"></i></div>
                        <h3 class="text-sm font-display font-bold text-gray-900">Kirim Notifikasi</h3>
                    </div>
                    <button onclick="document.getElementById('notifModal').classList.add('hidden')" class="w-7 h-7 rounded-lg bg-cream-100 hover:bg-cream-200 flex items-center justify-center text-gray-400 text-xs">&times;</button>
                </div>
                <p class="text-xs text-gray-500 mb-4">Kirim pengingat ke <strong>semua penyewa</strong> dengan tagihan belum dibayar.</p>
                <div class="bg-amber-50/80 border border-amber-100/50 rounded-xl p-3 mb-4 flex items-start gap-2">
                    <i class="bi bi-info-circle-fill text-amber-600 text-xs mt-0.5"></i>
                    <p class="text-[10px] text-amber-700">Notifikasi dikirim ke email penyewa terdaftar</p>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('pembayaran.notifikasi-semua') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold text-xs transition-all hover:-translate-y-0.5 active:scale-[0.97] flex items-center justify-center gap-2 shadow-md">
                            <i class="bi bi-send-fill"></i> Kirim Semua
                        </button>
                    </form>
                    <button onclick="document.getElementById('notifModal').classList.add('hidden')" 
                            class="px-4 py-2.5 rounded-xl border border-cream-200 text-gray-500 font-semibold text-xs transition-all hover:bg-cream-50 active:scale-[0.97]">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 400, once: true, offset: 10 });</script>
</body>
</html>
