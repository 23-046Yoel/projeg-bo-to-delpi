<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Menu MBG | Alad Elphi</title>
    <meta name="description" content="Lihat jadwal menu harian Program Makan Bergizi Gratis (MBG) dari Yayasan Alad Elphi & Badan Gizi Nasional.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,900&family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #0F172A;
            --accent: #D4AF37;
            --glass: rgba(255, 255, 255, 0.8);
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
            background-image:
                radial-gradient(circle at 80% 10%, rgba(212,175,55,0.05) 0%, transparent 50%),
                radial-gradient(circle at 10% 90%, rgba(15,23,42,0.03) 0%, transparent 50%);
        }
        .playfair { font-family: 'Playfair Display', serif; }
        .glass {
            background: var(--glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.4);
        }
        .hero-gradient { background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%); }

        /* Ticker */
        .ticker-container { width:100%; overflow:hidden; background:#0F172A; height:44px; display:flex; align-items:center; position:sticky; top:0; z-index:50; border-bottom:1px solid rgba(212,175,55,0.2); }
        .ticker-header { background:#D4AF37; color:#0F172A; padding:0 20px; height:100%; display:flex; align-items:center; font-weight:900; font-size:11px; letter-spacing:0.2em; z-index:2; position:relative; box-shadow:10px 0 30px rgba(0,0,0,0.3); flex-shrink:0; }
        .ticker-header::after { content:''; position:absolute; right:-15px; top:0; border-left:15px solid #D4AF37; border-bottom:44px solid transparent; }

        /* Card hover */
        .menu-card { transition: all 0.3s ease; }
        .menu-card:hover { transform: translateY(-4px); }

        /* dot colors */
        .dot-karbo    { background: #f59e0b; }
        .dot-protein  { background: #ef4444; }
        .dot-nabati   { background: #8b5cf6; }
        .dot-sayur    { background: #22c55e; }
        .dot-buah     { background: #06b6d4; }
        .dot-pelengkap{ background: #ec4899; }

        .animate-pulse-slow { animation: pulse 3s cubic-bezier(0.4,0,0.6,1) infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.7} }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 4px; }
    </style>
</head>
<body class="antialiased">

    <!-- Ticker -->
    <div class="ticker-container">
        <div class="ticker-header">
            <span class="animate-pulse-slow">JADWAL MENU</span>
        </div>
        <div class="flex-1 overflow-hidden flex items-center pl-8">
            <span class="text-white/60 text-xs font-semibold">
                Menu bergizi harian dari dapur-dapur SPPG Alad Elphi — Program Makan Bergizi Gratis (MBG) &nbsp;🍱&nbsp; Badan Gizi Nasional
            </span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-6">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#0F172A] rounded-xl flex items-center justify-center text-[#D4AF37] font-black text-xl italic shadow-lg shadow-[#0F172A]/20">B</div>
                <span class="font-black italic text-2xl tracking-tighter text-[#0F172A] playfair">BoTo Delphi</span>
            </a>
            <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>
            <div class="hidden md:flex items-center gap-4 opacity-80">
                <img src="/images/bgn_logo.png" alt="BGN" class="h-10 w-auto">
                <img src="/images/ala_delphi.png" alt="Alad Elphi" class="h-10 w-auto">
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="/" class="text-slate-500 font-bold text-sm hover:text-[#0F172A] transition-colors">Beranda</a>
            <a href="/jadwal-menu" class="text-[#D4AF37] font-bold text-sm">Jadwal Menu</a>
            <a href="/dapur" class="text-slate-500 font-bold text-sm hover:text-[#0F172A] transition-colors">Profil Dapur</a>
            <a href="/complaints/create" class="px-6 py-2 rounded-full border-2 border-[#0F172A] text-[#0F172A] font-bold text-sm hover:bg-[#0F172A] hover:text-white transition-all">Pengaduan</a>
        </div>
    </nav>

    <!-- Hero -->
    <div class="hero-gradient py-16 px-6 text-center relative overflow-hidden">
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-96 h-96 bg-[#D4AF37]/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl mx-auto">
            <a href="/" class="inline-flex items-center gap-2 text-white/50 text-xs font-bold hover:text-[#D4AF37] transition-colors mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Beranda
                <span class="px-3 py-1 bg-[#D4AF37]/20 border border-[#D4AF37]/40 text-[#D4AF37] rounded-full text-[10px] font-black uppercase tracking-widest ml-2">Program MBG</span>
            </a>
            <h1 class="playfair text-4xl lg:text-6xl font-black italic text-white leading-tight mb-4">
                Jadwal Menu <span class="text-[#D4AF37]">Harian</span> 🍱
            </h1>
            <p class="text-white/50 text-sm font-medium max-w-md mx-auto">
                Menu bergizi yang disiapkan oleh dapur-dapur SPPG Alad Elphi setiap harinya untuk anak-anak generasi bangsa.
            </p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center gap-4 flex-wrap">
            <form method="GET" action="/jadwal-menu" class="flex items-center gap-4 flex-wrap">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Filter Dapur:</label>
                <select name="sppg_id" onchange="this.form.submit()"
                    class="px-4 py-2.5 border-2 border-slate-200 rounded-2xl text-sm font-bold text-[#0F172A] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 outline-none transition-all cursor-pointer">
                    <option value="">-- Semua Dapur --</option>
                    @foreach($sppgs as $sppg)
                        <option value="{{ $sppg->id }}" {{ request('sppg_id') == $sppg->id ? 'selected' : '' }}>
                            {{ $sppg->name }}
                        </option>
                    @endforeach
                </select>
                @if(request('sppg_id'))
                    <a href="/jadwal-menu" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:text-red-700 transition-colors">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-12 pb-24">
        @if($menus->isEmpty())
            <div class="text-center py-24">
                <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <p class="playfair text-2xl font-black italic text-[#0F172A] mb-2">Belum Ada Jadwal Menu</p>
                <p class="text-gray-400 text-sm">Menu untuk dapur ini belum dipublikasikan.</p>
            </div>
        @else
            @foreach($menus as $date => $dayMenus)
                @php
                    $isToday = $date === $today;
                    $isTomorrow = $date === \Carbon\Carbon::tomorrow()->toDateString();
                    $tgl = \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y');
                @endphp

                <div class="mb-12">
                    <!-- Date Header -->
                    <div class="flex items-center gap-4 mb-6">
                        @if($isToday)
                            <span class="px-5 py-2 bg-[#D4AF37] text-[#0F172A] rounded-full text-sm font-black uppercase tracking-widest shadow-lg shadow-[#D4AF37]/30">
                                📍 {{ $tgl }} — Hari Ini
                            </span>
                        @elseif($isTomorrow)
                            <span class="px-5 py-2 bg-[#0F172A] text-[#D4AF37] rounded-full text-sm font-black uppercase tracking-widest shadow-lg shadow-[#0F172A]/20">
                                ⏭ {{ $tgl }} — Besok
                            </span>
                        @else
                            <span class="px-5 py-2 bg-white border-2 border-slate-200 text-[#0F172A] rounded-full text-sm font-black uppercase tracking-widest">
                                {{ $tgl }}
                            </span>
                        @endif
                        <div class="flex-1 h-[1px] bg-slate-200"></div>
                    </div>

                    <!-- Menu Cards Grid -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($dayMenus as $menu)
                            <div class="menu-card glass bg-white rounded-[2rem] p-7 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:border-[#D4AF37]/30 relative overflow-hidden group">
                                <!-- blob -->
                                <div class="absolute -top-8 -right-8 w-28 h-28 bg-[#D4AF37]/8 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700 pointer-events-none"></div>

                                <div class="relative z-10">
                                    <!-- Dapur badge -->
                                    <div class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.2em] mb-2 flex items-center gap-1">
                                        🍳 {{ $menu->sppg->name ?? 'Semua Dapur' }}
                                    </div>
                                    <h3 class="playfair text-xl font-black italic text-[#0F172A] mb-5">
                                        Menu {{ \Carbon\Carbon::parse($menu->date)->translatedFormat('l') }}
                                    </h3>

                                    <div class="space-y-3">
                                        @if($menu->karbo)
                                        <div class="flex items-start gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full dot-karbo shrink-0 mt-1.5"></span>
                                            <div>
                                                <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Karbohidrat</div>
                                                <div class="text-sm font-bold text-[#0F172A]">{{ $menu->karbo }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($menu->protein_hewani)
                                        <div class="flex items-start gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full dot-protein shrink-0 mt-1.5"></span>
                                            <div>
                                                <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Protein Hewani</div>
                                                <div class="text-sm font-bold text-[#0F172A]">{{ $menu->protein_hewani }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($menu->protein_nabati)
                                        <div class="flex items-start gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full dot-nabati shrink-0 mt-1.5"></span>
                                            <div>
                                                <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Protein Nabati</div>
                                                <div class="text-sm font-bold text-[#0F172A]">{{ $menu->protein_nabati }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($menu->sayur)
                                        <div class="flex items-start gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full dot-sayur shrink-0 mt-1.5"></span>
                                            <div>
                                                <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Sayuran</div>
                                                <div class="text-sm font-bold text-[#0F172A]">{{ $menu->sayur }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($menu->buah)
                                        <div class="flex items-start gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full dot-buah shrink-0 mt-1.5"></span>
                                            <div>
                                                <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Buah</div>
                                                <div class="text-sm font-bold text-[#0F172A]">{{ $menu->buah }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($menu->pelengkap)
                                        <div class="flex items-start gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full dot-pelengkap shrink-0 mt-1.5"></span>
                                            <div>
                                                <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Pelengkap</div>
                                                <div class="text-sm font-bold text-[#0F172A]">{{ $menu->pelengkap }}</div>
                                            </div>
                                        </div>
                                        @endif

                                        @if($menu->dishes->count() > 0)
                                        <div class="pt-4 mt-2 border-t border-slate-100">
                                            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-3">🍽️ Hidangan & Bahan Baku</div>
                                            @foreach($menu->dishes as $dish)
                                                @php $totalPortions = $sppgPortions[$menu->sppg_id] ?? 0; @endphp
                                                <div class="mb-3">
                                                    <p class="text-sm font-black text-[#0F172A] mb-1.5">{{ $dish->name }}</p>
                                                    @foreach($dish->recipes as $recipe)
                                                        @php $totalQty = $recipe->quantity * $totalPortions; @endphp
                                                        <div class="flex justify-between items-center py-1 px-2 rounded-lg hover:bg-slate-50 transition-colors">
                                                            <span class="text-xs text-slate-500 font-medium">• {{ $recipe->material->name ?? 'Bahan' }}</span>
                                                            <span class="text-xs font-black text-[#B8860B] bg-[#D4AF37]/10 px-2 py-0.5 rounded-full">{{ number_format($totalQty, 2) }} {{ $recipe->unit }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach

                                            <!-- Supplier CTA -->
                                            @php
                                                $suppWaText = "Halo Admin, saya tertarik menjadi pemasok bahan untuk menu " . \Carbon\Carbon::parse($menu->date)->translatedFormat('l, d F Y') . " di " . ($menu->sppg->name ?? 'Dapur SPPG') . ". Mohon info lebih lanjut.";
                                                $suppWaLink = "https://wa.me/6285353325352?text=" . urlencode($suppWaText);
                                            @endphp
                                            <a href="{{ $suppWaLink }}" target="_blank" rel="noopener"
                                               class="mt-3 flex items-center justify-between gap-2 px-4 py-3 bg-[#0F172A] text-white rounded-2xl group/cta hover:bg-[#D4AF37] transition-all duration-300 shadow-lg shadow-[#0F172A]/10">
                                                <div>
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-[#D4AF37] group-hover/cta:text-[#0F172A] transition-colors">🤝 Peluang Pemasok</p>
                                                    <p class="text-xs font-bold mt-0.5 group-hover/cta:text-[#0F172A] transition-colors">Ajukan Penawaran →</p>
                                                </div>
                                                <svg class="w-5 h-5 text-[#D4AF37] group-hover/cta:text-[#0F172A] group-hover/cta:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-[#0F172A] text-white py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-xl flex items-center justify-center text-[#D4AF37] font-black text-xl italic">B</div>
                <span class="playfair font-black italic text-xl text-white">BoTo Delphi</span>
            </div>
            <p class="text-white/40 text-xs font-bold text-center">
                © {{ date('Y') }} Program Makan Bergizi Gratis (MBG) — Yayasan Alad Elphi & Badan Gizi Nasional
            </p>
            <div class="flex gap-6">
                <a href="/dapur" class="text-[#D4AF37] text-xs font-bold hover:text-white transition-colors">Profil Dapur</a>
                <a href="/complaints/create" class="text-[#D4AF37] text-xs font-bold hover:text-white transition-colors">Pengaduan</a>
                <a href="/pendaftaran-pemasok" class="text-[#D4AF37] text-xs font-bold hover:text-white transition-colors">Daftar Pemasok</a>
            </div>
        </div>
    </footer>

</body>
</html>
