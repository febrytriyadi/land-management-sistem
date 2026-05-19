<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PT Inhutani I</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { forest: { 600: '#2D5A27', 500: '#3D7A2A' }, cream: { 50: '#FDFBF7', 100: '#FAF5EB', 200: '#F5EDD8', 300: '#EDE0BD' }, lime: { 400: '#82C341', 500: '#76C124' } },
                    fontFamily: { display: ['Plus Jakarta Sans', 'Inter', 'sans-serif'], sans: ['Inter', 'sans-serif'] },
                    animation: { 'float': 'float 6s ease-in-out infinite', 'float-d': 'float 6s ease-in-out 2s infinite', 'gradient-x': 'gradientX 8s ease infinite', 'scale-in': 'scaleIn 0.5s cubic-bezier(0.34,1.56,0.64,1)' },
                    keyframes: {
                        float: { '0%,100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-20px)' } },
                        gradientX: { '0%,100%': { backgroundPosition: '0% 50%' }, '50%': { backgroundPosition: '100% 50%' } },
                        scaleIn: { '0%': { opacity: 0, transform: 'scale(0.8)' }, '100%': { opacity: 1, transform: 'scale(1)' } },
                    }
                }
            }
        }
    </script>
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-cream-100 via-cream-50 to-forest-50 flex items-center justify-center p-4" style="background-size:400% 400%;animation:gradientX 15s ease infinite;">
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full bg-forest-200/20 animate-float blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 rounded-full bg-cream-300/20 animate-float-d blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-[400px] animate-scale-in">
        <div class="absolute -inset-4 bg-gradient-to-r from-forest-600/5 to-cream-400/5 rounded-[2.5rem] blur-2xl"></div>
        
        <div class="relative bg-white/90 backdrop-blur-2xl border border-white/50 p-8 lg:p-10"
             style="border-radius:2rem;box-shadow:0 40px 80px -12px rgba(45,90,39,0.25),0 0 0 1px rgba(255,255,255,0.5);">
            
            <div class="text-center mb-8">
                <img src="{{ asset('logo-inhutani.jpg') }}" alt="Logo Inhutani I" 
                     class="w-20 h-20 mx-auto rounded-2xl object-cover ring-4 ring-white shadow-xl mb-4">
                <h1 class="text-xl font-display font-extrabold text-gray-900">Inhutani I</h1>
                <p class="text-xs text-gray-400 mt-1 font-medium">Land Management System</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <i class="bi bi-envelope-fill absolute left-4 top-1/2 -translate-y-1/2 text-sm text-cream-300"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3.5 text-sm rounded-xl bg-cream-50/80 border-2 border-cream-200/60 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 outline-none transition-all duration-300"
                               placeholder="admin@inhutani.id">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-sm text-cream-300"></i>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-4 py-3.5 text-sm rounded-xl bg-cream-50/80 border-2 border-cream-200/60 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 outline-none transition-all duration-300"
                               placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" 
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-forest-600 to-forest-500 text-white font-bold text-sm transition-all duration-500 hover:shadow-[0_12px_32px_-8px_rgba(45,90,39,0.4)] hover:-translate-y-0.5 active:scale-[0.98] flex items-center justify-center gap-2">
                    Masuk <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="mt-6 p-4 rounded-xl bg-gradient-to-br from-cream-50 to-forest-50/50 border border-cream-200/40">
                <p class="text-[10px] font-semibold text-gray-400 mb-2.5 text-center uppercase tracking-wider">Demo Akses</p>
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <div class="bg-white/70 rounded-lg px-3 py-2 text-center">
                        <p class="text-gray-400 text-[9px]">Email</p>
                        <p class="font-semibold text-gray-700 mt-0.5">admin@inhutani.id</p>
                    </div>
                    <div class="bg-white/70 rounded-lg px-3 py-2 text-center">
                        <p class="text-gray-400 text-[9px]">Password</p>
                        <p class="font-semibold text-gray-700 mt-0.5">admin123</p>
                    </div>
                </div>
            </div>
            <p class="text-center text-[10px] text-gray-300 mt-6">© {{ date('Y') }} PT Inhutani I</p>
        </div>
    </div>
</body>
</html>
