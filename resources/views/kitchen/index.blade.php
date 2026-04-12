<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Dapur MBG - BoTo Delphi</title>
    <meta name="description" content="Profil lengkap semua dapur SPPG MBG di wilayah layanan Yayasan Ala Delphi.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #F8FAFC; }
        .playfair { font-family: 'Playfair Display', serif; }
        .hero-grad { background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%); }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 40px 80px rgba(0,0,0,0.12); }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#0F172A] rounded-xl flex items-center justify-center text-[#D4AF37] font-black text-lg italic">B</div>
                    <span class="playfair font-black italic text-xl text-[#0F172A]">BoTo Delphi</span>
                </a>
                <span class="text-slate-300 hidden md:block">/</span>
                <span class="text-sm font-bold text-[#D4AF37] hidden md:block uppercase tracking-widest">Profil Dapur</span>
            </div>
            @auth
            <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-full bg-[#0F172A] text-white font-bold text-xs tracking-widest uppercase hover:scale-105 transition-all">Dashboard</a>
            @else
            <a href="{{ route('login.wa') }}" class="px-5 py-2 rounded-full border-2 border-[#0F172A] text-[#0F172A] font-bold text-xs tracking-widest uppercase hover:bg-[#0F172A] hover:text-white transition-all">Masuk</a>
            @endauth
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-grad py-24 text-white text-center">
        <div class="max-w-3xl mx-auto px-6">
            <span class="inline-block px-4 py-1 rounded-full bg-[#D4AF37]/20 text-[#D4AF37] font-black text-xs uppercase tracking-[0.3em] mb-6">Satuan Pelayanan Pemenuhan Gizi</span>
            <h1 class="playfair text-5xl lg:text-6xl font-black italic leading-tight mb-6">Mengenal <span class="text-[#D4AF37]">Dapur-dapur</span> MBG</h1>
            <p class="text-slate-300 text-lg leading-relaxed max-w-xl mx-auto">{{ $kitchens->count() }} dapur aktif melayani ribuan penerima manfaat setiap hari di wilayah Simalungun.</p>
        </div>
    </section>

    <!-- Kitchen Grid -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($kitchens as $kitchen)
            @php
                $now = now();
                $hours = $kitchen->operational_hours ?? '06:00 - 14:00';
                [$start, $end] = explode(' - ', $hours . ' - 14:00');
                try {
                    $isOps = $now->between($now->copy()->setTimeFromTimeString($start), $now->copy()->setTimeFromTimeString($end));
                } catch(\Exception $e) { $isOps = false; }
            @endphp
            <a href="{{ route('kitchens.show', $kitchen->slug ?? $kitchen->id) }}" class="card-hover block bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-lg">
                <!-- Cover Image -->
                <div class="relative h-48 bg-gradient-to-br from-[#0F172A] to-slate-700">
                    @if($kitchen->image_path)
                    <img src="{{ Storage::url($kitchen->image_path) }}" class="w-full h-full object-cover opacity-70" alt="{{ $kitchen->name }}">
                    @else
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-16 h-16 text-[#D4AF37]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    @endif
                    <!-- Live Status Badge -->
                    <div class="absolute top-4 left-4">
                        @if($isOps)
                        <span class="flex items-center gap-2 px-3 py-1 bg-emerald-500/90 backdrop-blur rounded-full text-white text-[10px] font-black uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>Sedang Beroperasi
                        </span>
                        @else
                        <span class="px-3 py-1 bg-slate-700/80 backdrop-blur rounded-full text-slate-300 text-[10px] font-black uppercase tracking-widest">Tutup</span>
                        @endif
                    </div>
                </div>
                <!-- Info -->
                <div class="p-6">
                    <h2 class="font-black text-[#0F172A] text-lg playfair italic mb-1">{{ $kitchen->name }}</h2>
                    @if($kitchen->address)
                    <p class="text-xs text-slate-400 font-medium mb-3 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        {{ $kitchen->address }}
                    </p>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-[#D4AF37] uppercase tracking-widest">{{ $kitchen->beneficiaries_count ?? 0 }} Penerima</span>
                        <span class="text-[10px] text-slate-400 font-bold">{{ $kitchen->operational_hours ?? '06:00 - 14:00' }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center py-20 text-slate-400">
                <p class="text-lg font-bold">Belum ada data dapur terdaftar.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0F172A] text-slate-400 text-center py-8">
        <p class="text-xs font-bold uppercase tracking-widest">© 2026 BoTo Delphi MBG Foundation Hub</p>
        <div class="flex justify-center gap-6 mt-4">
            <a href="{{ url('/') }}" class="text-xs font-bold hover:text-[#D4AF37] transition-colors">Beranda</a>
            <a href="{{ route('prices.index') }}" class="text-xs font-bold hover:text-[#D4AF37] transition-colors">Harga Pangan</a>
            <a href="{{ route('community-prices.index') }}" class="text-xs font-bold hover:text-[#D4AF37] transition-colors">Harga Komunitas</a>
        </div>
    </footer>

</body>
</html>
