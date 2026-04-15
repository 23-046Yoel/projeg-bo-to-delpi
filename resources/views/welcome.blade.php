<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BoTo Delphi - MBG Foundation Hub</title>
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
            background-image: radial-gradient(circle at 80% 10%, rgba(212,175,55,0.05) 0%, transparent 50%),
                              radial-gradient(circle at 10% 90%, rgba(15,23,42,0.03) 0%, transparent 50%);
        }
        .playfair { font-family: 'Playfair Display', serif; }
        .glass {
            background: var(--glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%);
        }
        .ticker-wrap {
            width: 100%;
            overflow: hidden;
            background: #0F172A;
            color: #fff;
            padding: 10px 0;
        }
        .ticker {
            display: inline-block;
            white-space: nowrap;
            padding-right: 100%;
            animation: ticker 30s linear infinite;
        }
        @keyframes ticker {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }
        .youtube-card {
            transition: transform 0.3s ease;
        }
        .youtube-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="antialiased">

    <!-- News Ticker -->
    @php
        $latest_news = \App\Models\News::latest()->take(5)->get();
        $active_aspirations = \App\Models\Aspiration::where('is_active', true)->latest()->take(5)->get();
    @endphp
    @if($latest_news->count() > 0 || $active_aspirations->count() > 0)
    <div class="ticker-wrap sticky top-0 z-50">
        <div class="ticker">
            @foreach($latest_news as $news)
                <span class="mx-8 font-semibold text-sm uppercase tracking-widest text-[#D4AF37]">
                    📢 {{ $news->title }}
                </span>
            @endforeach
            @foreach($active_aspirations as $asp)
                <span class="mx-8 font-semibold text-sm tracking-widest text-white/80">
                    💬 <em>{{ $asp->sender_name }} ({{ $asp->location }}):</em> {{ Str::limit($asp->content, 80) }}
                </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Navbar -->
    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-royal-navy rounded-xl flex items-center justify-center text-gold font-black text-xl italic shadow-lg shadow-royal-navy/20">B</div>
                <span class="playfair font-black italic text-2xl tracking-tighter text-[#0F172A]">BoTo Delphi</span>
            </div>
            <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>
            <div class="flex items-center gap-4 hidden md:flex opacity-80 transition-opacity hover:opacity-100">
                <a href="https://bgn.go.id" target="_blank" rel="noopener">
                    <img src="{{ asset('images/bgn_logo.png') }}" alt="Badan Gizi Nasional" class="h-10 w-auto hover:opacity-100 opacity-80 transition-opacity">
                </a>
                <img src="{{ asset('images/ala_delphi.png') }}" alt="Yayasan ALA DELPHI" class="h-10 w-auto">
            </div>
        </div>
        <div class="flex gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-2 rounded-full hero-gradient text-white font-bold text-sm hover:scale-105 transition-all">Dashboard</a>
            @else
                <a href="{{ route('suppliers.register') }}" class="px-6 py-2 rounded-full border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">Jadi Pemasok</a>
                <a href="{{ route('login.wa') }}" class="px-6 py-2 rounded-full border-2 border-[#0F172A] text-[#0F172A] font-bold text-sm hover:bg-[#0F172A] hover:text-white transition-all">Masuk WA</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-12 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-block px-4 py-1 rounded-full bg-[#D4AF37]/10 text-[#B8860B] font-black text-xs uppercase tracking-[0.2em] mb-6">Makan Bergizi Gratis (MBG)</span>
            <h1 class="playfair text-5xl lg:text-7xl font-black italic text-[#0F172A] leading-tight mb-8">
                Membangun Generasi <br> <span class="text-[#D4AF37]">Emas 2045</span> Melalui Gizi.
            </h1>
            <div class="space-y-6 text-gray-600 text-lg leading-relaxed mb-10">
                <p><strong>Visi:</strong> Menjadi pilar utama dalam memastikan setiap anak Indonesia mendapatkan akses makanan bergizi yang layak, transparan, dan berkelanjutan.</p>
                <p><strong>Misi:</strong> Mengintegrasikan teknologi dalam manajemen rantai pasok pangan, memberdayakan petani lokal, dan menjamin akuntabilitas setiap butir nasi yang disajikan.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('login.wa') }}" class="px-8 py-4 rounded-xl hero-gradient text-white font-black text-xs tracking-[0.2em] uppercase shadow-xl shadow-slate-900/20 hover:scale-105 transition-all">Mulai Kontribusi</a>
                <a href="{{ route('suppliers.register') }}" class="px-8 py-4 rounded-xl border-2 border-gold text-gold font-black text-xs tracking-[0.2em] uppercase hover:bg-gold hover:text-white transition-all shadow-lg shadow-gold/10">Jadi Pemasok</a>
            </div>
        </div>
        <div class="relative">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#D4AF37]/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div class="glass p-4 rounded-[2.5rem] relative overflow-hidden shadow-2xl">
                <img src="{{ asset('images/indonesia_mbg.png') }}" alt="Makan Bergizi Gratis" class="rounded-[2rem] w-full h-[500px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/80 to-transparent flex items-end p-12">
                    <div>
                        <p class="text-white/60 font-semibold mb-2">Didistribusikan Ke</p>
                        <p class="text-white text-3xl font-black playfair italic tracking-tight">{{ number_format($stats['beneficiaries_count']) }} Penerima Manfaat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="bg-[#0F172A] py-20 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 relative z-10">
            <div class="text-center">
                <div class="text-[#D4AF37] text-4xl font-black mb-2">{{ $stats['posts_count'] }}</div>
                <div class="text-slate-400 text-xs uppercase tracking-widest font-bold">Jumlah Postingan</div>
            </div>
            <div class="text-center border-x border-slate-800 px-12">
                <div class="text-[#D4AF37] text-4xl font-black mb-2">{{ $stats['beneficiaries_per_kitchen'] }}</div>
                <div class="text-slate-400 text-xs uppercase tracking-widest font-bold">Penerima Manfaat Tiap Dapur</div>
            </div>
            <div class="text-center">
                <div class="text-[#D4AF37] text-4xl font-black mb-2">{{ $stats['tutorials_count'] }}</div>
                <div class="text-slate-400 text-xs uppercase tracking-widest font-bold">Video Tutorial Terupload</div>
            </div>
        </div>
    </section>

    </section>

    <!-- Services Section -->
    <section class="bg-slate-50 py-24 border-y border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/5 rounded-full blur-[100px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 rounded-full bg-gold/10 text-gold-dark font-black text-[10px] uppercase tracking-[0.3em] mb-4">Layanan Unggulan</span>
                <h2 class="playfair text-4xl lg:text-6xl font-black italic text-[#0F172A] mb-6">Integrasi Gizi & <span class="text-gold">Pelaporan Terpadu</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Kami menghubungkan tenaga ahli gizi dengan masyarakat, serta memastikan setiap unit dapur melaporkan kegiatan secara real-time demi akuntabilitas publik.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mt-12">
                <!-- Nutrition Consultation Card -->
                <div class="group bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-xl hover:shadow-2xl transition-all duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gold/5 rounded-full -translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gold/10 rounded-2xl flex items-center justify-center text-gold mb-8 group-hover:bg-gold group-hover:text-white transition-all duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="playfair text-3xl font-black italic text-[#0F172A] mb-4">Konsultasi Gizi Gratis</h3>
                        <p class="text-gray-500 leading-relaxed mb-8">Dapatkan bimbingan kesehatan langsung dari ahli gizi profesional untuk mendukung pertumbuhan anak dan kesehatan keluarga melalui program MBG.</p>
                        
                        <ul class="space-y-3 mb-10">
                            <li class="flex items-center gap-3 text-sm font-bold text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Rekomendasi Menu Harian Sehat
                            </li>
                            <li class="flex items-center gap-3 text-sm font-bold text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Monitoring Grafik Pertumbuhan Anak
                            </li>
                        </ul>

                        <a href="{{ route('nutrition.consultation') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-[#0F172A] text-white font-black text-xs tracking-widest uppercase rounded-2xl group-hover:bg-gold transition-all duration-300">
                            Daftar Konsultasi
                            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Daily Reporting Card -->
                <div class="group bg-[#0F172A] rounded-[2.5rem] p-10 border border-white/5 shadow-2xl hover:shadow-gold/20 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition-transform duration-700"></div>

                    <div class="relative z-10 text-white">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-gold mb-8 group-hover:bg-white group-hover:text-[#0F172A] transition-all duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <h3 class="playfair text-3xl font-black italic mb-4">Pelaporan Harian SPPG</h3>
                        <p class="text-white/60 leading-relaxed mb-8">Pilar utama transparansi program. Seluruh unit dapur (SPPG) wajib melaporkan distribusi makanan setiap sesi secara akurat.</p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-10">
                            <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                                <p class="text-gold text-xl font-black mb-1">99%</p>
                                <p class="text-[10px] text-white/40 font-black uppercase tracking-widest leading-tight">Tingkat Kepatuhan Laporan</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                                <p class="text-gold text-xl font-black mb-1">Harian</p>
                                <p class="text-[10px] text-white/40 font-black uppercase tracking-widest leading-tight">Update Dokumentasi Real-time</p>
                            </div>
                        </div>

                        <a href="{{ route('reports.daily') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-gold text-white font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-white hover:text-[#0F172A] transition-all duration-300">
                            Upload Laporan Sesi
                            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <!-- YouTube & Tutorials -->
    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h2 class="playfair text-4xl lg:text-5xl font-black italic text-[#0F172A] mb-4">Tutorial Memasak MBG</h2>
                <p class="text-gray-500 max-w-xl">Intip proses pembuatan makanan bergizi langsung dari dapur kami melalui video tutorial singkat.</p>
            </div>
            <a href="{{ route('login.wa') }}" class="px-6 py-3 rounded-lg border border-slate-200 text-sm font-bold hover:bg-slate-50 transition-all flex items-center gap-2">
                Masuk & Lihat Semua Tutorial
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        @php
            $dishVideos = \App\Models\Dish::whereNotNull('youtube_url')->latest()->take(3)->get();
            // Helper: extract YouTube ID using closure to avoid redeclaration issues
            $extractYoutubeId = function($url) {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url ?? '', $match);
                return $match[1] ?? null;
            };
        @endphp

        @if($dishVideos->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($dishVideos as $dish)
            @php $ytId = $extractYoutubeId($dish->youtube_url); @endphp
            <div class="youtube-card glass rounded-[1.5rem] overflow-hidden shadow-lg border border-slate-100">
                <div class="bg-slate-200 relative" style="aspect-ratio:9/16;">
                    @if($ytId)
                        <iframe class="w-full h-full absolute inset-0" src="https://www.youtube.com/embed/{{ $ytId }}?controls=1&modestbranding=1&rel=0" title="{{ $dish->name }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center">
                            <div class="text-center p-4">
                                <div class="w-14 h-14 bg-[#D4AF37] rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"/></svg>
                                </div>
                                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Video Segera Hadir</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="font-black text-[#0F172A] mb-1 italic">{{ $dish->name }}</h3>
                    <p class="text-xs text-[#D4AF37] font-bold uppercase tracking-wider">Tutorial Langkah-demi-Langkah</p>
                    @if($dish->description)
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $dish->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Video YouTube memasak nyata sebagai konten default --}}
        @php
            $defaultVideos = [
                [
                    'ytId'  => 'KMAbMJy_Qsg',
                    'title' => 'Ayam Goreng Bumbu Kuning',
                    'desc'  => 'Resep ayam goreng bergizi, gurih, dan mudah dipraktekkan di dapur SPPG.',
                    'tag'   => 'Protein Tinggi',
                    'href'  => 'https://www.youtube.com/watch?v=KMAbMJy_Qsg',
                ],
                [
                    'ytId'  => 'XFEMChRZ_0k',
                    'title' => 'Sayur Sop Sehat & Bergizi',
                    'desc'  => 'Sup sayuran segar kaya vitamin, cocok untuk menu MBG harian anak sekolah.',
                    'tag'   => 'Rendah Kalori',
                    'href'  => 'https://www.youtube.com/watch?v=XFEMChRZ_0k',
                ],
                [
                    'ytId'  => 'q4S9d7lHVTQ',
                    'title' => 'Nasi Goreng Bergizi MBG',
                    'desc'  => 'Nasi goreng sehat dengan tambahan sayur dan protein, standar gizi nasional.',
                    'tag'   => 'Favorit Anak',
                    'href'  => 'https://www.youtube.com/watch?v=q4S9d7lHVTQ',
                ],
            ];
        @endphp
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($defaultVideos as $vid)
            <div class="youtube-card glass rounded-[1.5rem] overflow-hidden shadow-lg border border-slate-100">
                {{-- Video Player --}}
                <div class="relative bg-black" style="aspect-ratio:9/16;">
                    <iframe
                        class="absolute inset-0 w-full h-full"
                        src="https://www.youtube.com/embed/{{ $vid['ytId'] }}?controls=1&modestbranding=1&rel=0&playsinline=1"
                        title="{{ $vid['title'] }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
                {{-- Info Card --}}
                <div class="p-6">
                    <span class="inline-block px-2 py-0.5 rounded-full bg-[#D4AF37]/10 text-[#B8860B] text-[10px] font-black uppercase tracking-widest mb-2">{{ $vid['tag'] }}</span>
                    <h3 class="font-black text-[#0F172A] mb-1 italic text-base leading-tight">{{ $vid['title'] }}</h3>
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">{{ $vid['desc'] }}</p>
                    <a href="{{ $vid['href'] }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 text-xs font-black text-[#0F172A] uppercase tracking-widest group">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        Tonton di YouTube
                        <span class="w-6 h-0.5 bg-[#D4AF37] group-hover:w-12 transition-all duration-300"></span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    <!-- Public Links & Transparency -->
    <section class="max-w-7xl mx-auto px-6 py-24 border-t border-slate-100">
        <div class="text-center mb-16">
            <h2 class="playfair text-4xl lg:text-5xl font-black italic text-[#0F172A] mb-4">Transparansi Publik</h2>
            <div class="h-1 w-20 bg-gold mx-auto rounded-full mb-8"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Price Card -->
            <div class="glass p-8 rounded-[2.5rem] border border-slate-100 hover:border-gold/30 bg-white transition-all group">
                <div class="w-12 h-12 bg-gold/10 rounded-2xl flex items-center justify-center text-gold mb-6 group-hover:bg-gold group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="playfair text-xl font-black italic text-[#0F172A] mb-3">Harga Pangan</h3>
                <p class="text-gray-500 mb-6 text-xs leading-relaxed">Pantau harga bahan baku harian langsung dari petani mitra kami.</p>
                <a href="{{ route('prices.index') }}" class="text-[10px] font-black text-gold uppercase tracking-widest flex items-center group/link">
                    Cek Detail
                    <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Financial Card -->
            <div class="glass p-8 rounded-[2.5rem] border border-slate-100 hover:border-emerald-300/30 bg-white transition-all group">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="playfair text-xl font-black italic text-[#0F172A] mb-3">Dana Publik</h3>
                <p class="text-gray-500 mb-6 text-xs leading-relaxed">Rekap penggunaan anggaran MBG secara transparan dan akuntabel.</p>
                <a href="{{ route('recap.index') }}" class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center group/link">
                    Laporan Ringkas
                    <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Supplier Registration Card -->
            <div class="glass p-8 rounded-[2.5rem] border border-royal-navy/10 bg-royal-navy transition-all group">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-gold mb-6 group-hover:bg-gold group-hover:text-royal-navy transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h3 class="playfair text-xl font-black italic text-white mb-3">Mitra Pemasok</h3>
                <p class="text-white/50 mb-6 text-xs leading-relaxed">Daftarkan usaha Anda sebagai penyedia bahan baku berkualitas.</p>
                <a href="{{ route('suppliers.register') }}" class="text-[10px] font-black text-gold uppercase tracking-widest flex items-center group/link">
                    Daftar Sekarang
                    <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Complaint Card -->
            <div class="glass p-8 rounded-[2.5rem] border border-red-100 hover:border-red-300/30 bg-white transition-all group">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 mb-6 group-hover:bg-red-500 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="playfair text-xl font-black italic text-[#0F172A] mb-3">Pengaduan</h3>
                <p class="text-gray-500 mb-6 text-xs leading-relaxed">Laporkan ketidaksesuaian atau berikan saran perbaikan.</p>
                <a href="{{ route('complaints.create') }}" class="text-[10px] font-black text-red-600 uppercase tracking-widest flex items-center group/link">
                    Kirim Aduan
                    <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- SIPERDA External Link -->
            <div class="glass p-8 rounded-[2.5rem] border border-blue-100 hover:border-blue-300/30 bg-white transition-all group">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
                <h3 class="playfair text-xl font-black italic text-[#0F172A] mb-3">Siperda BGN</h3>
                <p class="text-gray-500 mb-6 text-xs leading-relaxed">Akses portal resmi Sistem Pelaporan Data Badan Gizi Nasional.</p>
                <a href="https://siperda.bgn.go.id" target="_blank" class="text-[10px] font-black text-blue-600 uppercase tracking-widest flex items-center group/link">
                    Buka Portal
                    <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Community Price Preview -->
    <section class="max-w-7xl mx-auto px-6 py-24 border-t border-slate-100">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <span class="inline-block px-4 py-1 rounded-full bg-emerald-100 text-emerald-700 font-black text-xs uppercase tracking-[0.2em] mb-4">Harga Dari Warga</span>
                <h2 class="playfair text-4xl lg:text-5xl font-black italic text-[#0F172A] mb-4">Feed Harga Komunitas</h2>
                <p class="text-gray-500 max-w-xl">Harga bahan pangan langsung dari petani dan pedagang. Transparansi dari bawah ke atas.</p>
            </div>
            <div class="flex flex-col gap-3">
                <a href="{{ route('community-prices.index') }}" class="px-6 py-3 rounded-lg border border-slate-200 text-sm font-bold hover:bg-slate-50 transition-all flex items-center gap-2">
                    Lihat Semua &amp; Lapor Harga
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="https://siperda.simalungunkab.go.id" target="_blank" class="px-6 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-sm font-bold text-emerald-700 hover:bg-emerald-100 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Harga Resmi di Siperda ↗
                </a>
            </div>
        </div>
        @php $communityPrices = \App\Models\CommunityPrice::latest()->take(4)->get(); @endphp
        @if($communityPrices->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($communityPrices as $cp)
            <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-md p-5 hover:shadow-lg transition-shadow">
                <div class="w-10 h-10 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-xl font-black text-[#D4AF37] mb-3">
                    {{ mb_substr($cp->item_name, 0, 1) }}
                </div>
                <h4 class="font-black text-[#0F172A] text-sm mb-1">{{ $cp->item_name }}</h4>
                <p class="text-lg font-black text-[#D4AF37]">Rp {{ number_format($cp->price, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">/ {{ $cp->unit }}</p>
                <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $cp->location }}
                </p>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-[2rem] border border-slate-100">
            <p class="text-slate-400 font-bold mb-4">Jadilah yang pertama melaporkan harga dari wilayah Anda!</p>
            <a href="{{ route('community-prices.index') }}" class="px-6 py-3 bg-[#0F172A] text-[#D4AF37] font-black text-xs uppercase tracking-widest rounded-xl hover:scale-105 transition-all">Laporan Sekarang</a>
        </div>
        @endif
    </section>

    <!-- Social Transparency Feed -->
    <section class="bg-silk/30 py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h2 class="playfair text-4xl lg:text-5xl font-black italic text-[#0F172A] mb-4">Aksi Nyata Dapur</h2>
                    <p class="text-gray-500 max-w-xl">Dokumentasi transparansi harian dari setiap unit SPPG di seluruh wilayah layanan kami.</p>
                </div>
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:text-royal-navy cursor-pointer transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                    <div class="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:text-royal-navy cursor-pointer transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @php
                    $news_feed = \App\Models\News::with('sppg')->latest()->take(4)->get();
                @endphp
                @forelse($news_feed as $post)
                    <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl border border-slate-100 group">
                        <div class="relative aspect-square overflow-hidden">
                            @if($post->image_path)
                                <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest text-royal-navy shadow-sm">
                                    {{ $post->sppg->name ?? 'Update SPPG' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-royal-navy text-sm line-clamp-1 mb-2">{{ $post->title }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-2 mb-4 leading-relaxed">{{ $post->content }}</p>
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                <span class="text-gold">★ Transparan</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Placeholder Posts for first appearance -->
                    @for($i=1; $i<=4; $i++)
                        <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl border border-slate-100 opacity-60">
                            <div class="aspect-square bg-slate-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div class="p-6">
                                <div class="h-4 bg-slate-100 rounded w-3/4 mb-3"></div>
                                <div class="h-3 bg-slate-50 rounded w-full mb-1"></div>
                                <div class="h-3 bg-slate-50 rounded w-2/3"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    <!-- Aspiration Section -->
    <section class="bg-[#0F172A] py-24">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="inline-block px-4 py-1 rounded-full bg-[#D4AF37]/20 text-[#D4AF37] font-black text-xs uppercase tracking-[0.3em] mb-6">Suara Masyarakat</span>
            <h2 class="playfair text-4xl lg:text-5xl font-black italic text-white mb-4">Sampaikan <span class="text-[#D4AF37]">Aspirasi</span> Anda</h2>
            <p class="text-slate-400 mb-10 max-w-lg mx-auto">Pesan Anda akan tampil di ticker setelah diverifikasi admin. Kritik, saran, dan harapan Anda demi perbaikan program MBG.</p>
            @if(session('aspiration_success'))
            <div class="p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-2xl text-emerald-300 font-bold mb-8">{{ session('aspiration_success') }}</div>
            @endif
            <form action="{{ route('aspirations.store') }}" method="POST" class="bg-white/5 border border-white/10 rounded-[2rem] p-8 text-left">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Nama Anda (Opsional)</label>
                        <input type="text" name="sender_name" placeholder="Anonim" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-sm font-bold text-white placeholder-slate-500 focus:border-[#D4AF37] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Lokasi / Daerah</label>
                        <input type="text" name="location" placeholder="Kec. Gunung Maligas, Simalungun" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-sm font-bold text-white placeholder-slate-500 focus:border-[#D4AF37] outline-none transition-all">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Aspirasi / Pesan *</label>
                    <textarea name="content" required rows="4" placeholder="Tulis aspirasi, saran, atau harapan Anda tentang program MBG..." class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-sm font-bold text-white placeholder-slate-500 focus:border-[#D4AF37] outline-none transition-all resize-none"></textarea>
                </div>
                <p class="text-[10px] text-slate-500 mb-6">* Aspirasi Anda akan ditampilkan di ticker setelah diverifikasi oleh Admin SPPG.</p>
                <button type="submit" class="w-full py-4 bg-[#D4AF37] text-[#0F172A] font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-gold/20 hover:scale-105 transition-all duration-300">
                    Kirim Aspirasi
                </button>
            </form>
        </div>
    </section>

    <!-- BGN Juknis Section -->
    <section class="max-w-7xl mx-auto px-6 py-24 border-t border-slate-100">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <span class="inline-block px-4 py-1 rounded-full bg-blue-100 text-blue-700 font-black text-xs uppercase tracking-[0.2em] mb-4">Resmi dari BGN</span>
                <h2 class="playfair text-4xl lg:text-5xl font-black italic text-[#0F172A] mb-4">Petunjuk Teknis <span class="text-[#D4AF37]">Resmi MBG</span></h2>
                <p class="text-gray-500 max-w-xl">Portal ini mengambil konten petunjuk teknis langsung dari situs resmi Badan Gizi Nasional untuk memastikan kepatuhan operasional.</p>
            </div>
            <a href="https://bgn.go.id/juknis" target="_blank" rel="noopener"
               class="px-6 py-3 rounded-lg border-2 border-blue-600 text-blue-700 font-black text-sm hover:bg-blue-600 hover:text-white transition-all flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Buka bgn.go.id/juknis ↗
            </a>
        </div>

        <!-- Grid Petunjuk Teknis -->
        <div class="grid md:grid-cols-3 gap-6 mb-10">
            @php
                $juknisLinks = [
                    ['title' => 'Petunjuk Teknis MBG 2025', 'desc' => 'Panduan teknis operasional program Makan Bergizi Gratis dari Badan Gizi Nasional Tahun 2025.', 'url' => 'https://bgn.go.id/juknis', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'blue'],
                    ['title' => 'Standar Gizi Anak MBG', 'desc' => 'Standar menu dan kandungan gizi minimum yang harus dipenuhi dalam setiap porsi makanan program MBG.', 'url' => 'https://bgn.go.id', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'emerald'],
                    ['title' => 'Prosedur Pengadaan Bahan', 'desc' => 'Tata cara pengadaan bahan baku, persyaratan pemasok, dan mekanisme pembayaran sesuai regulasi BGN.', 'url' => 'https://bgn.go.id', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'yellow'],
                ];
            @endphp
            @foreach($juknisLinks as $juknis)
            <a href="{{ $juknis['url'] }}" target="_blank" rel="noopener"
               class="group bg-white border border-slate-100 rounded-[2rem] p-8 shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6
                    {{ $juknis['color'] === 'blue' ? 'bg-blue-50 text-blue-500 group-hover:bg-blue-500 group-hover:text-white' : '' }}
                    {{ $juknis['color'] === 'emerald' ? 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white' : '' }}
                    {{ $juknis['color'] === 'yellow' ? 'bg-[#D4AF37]/10 text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-white' : '' }}
                    transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $juknis['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="playfair text-lg font-black italic text-[#0F172A] mb-3">{{ $juknis['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $juknis['desc'] }}</p>
                <span class="text-[10px] font-black uppercase tracking-widest
                    {{ $juknis['color'] === 'blue' ? 'text-blue-600' : '' }}
                    {{ $juknis['color'] === 'emerald' ? 'text-emerald-600' : '' }}
                    {{ $juknis['color'] === 'yellow' ? 'text-[#D4AF37]' : '' }}
                    flex items-center gap-2">
                    Baca Selengkapnya
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </a>
            @endforeach
        </div>

        <!-- Embedded Preview -->
        <!-- Official Portal Preview (Premium Replacement for Iframe) -->
        <div class="relative bg-white rounded-[3rem] border border-blue-100 shadow-2xl overflow-hidden group">
            <!-- Browser Header -->
            <div class="flex items-center justify-between px-8 py-5 bg-gradient-to-r from-blue-50 to-white border-b border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-slate-200"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-200"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-200"></div>
                    </div>
                    <div class="ml-4 px-4 py-1.5 bg-slate-100 rounded-full flex items-center gap-2">
                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        <span class="text-[10px] font-bold text-slate-500 font-mono tracking-tight">https://bgn.go.id/juknis</span>
                    </div>
                </div>
                <div class="hidden md:block text-[10px] font-black text-blue-300 uppercase tracking-[0.2em]">Official Portal Preview</div>
            </div>

            <!-- Content Area: Portal Teaser -->
            <div class="relative py-24 px-8 text-center bg-gradient-to-b from-white to-blue-50/30">
                <div class="max-w-xl mx-auto">
                    <div class="w-20 h-20 bg-blue-600 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-blue-600/20 group-hover:rotate-12 transition-transform duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="playfair text-3xl font-black italic text-[#0F172A] mb-4">Akses Langsung Juknis Resmi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-10 px-4">
                        Demi keamanan data dan kebijakan otoritas pusat, Petunjuk Teknis (Juknis) Badan Gizi Nasional hanya dapat diakses langsung melalui portal resmi lembaga.
                    </p>
                    <a href="https://bgn.go.id/juknis" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-4 px-10 py-5 bg-blue-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-blue-600/30 hover:scale-105 hover:bg-blue-700 transition-all duration-300">
                        Buka Portal bgn.go.id
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

            <!-- Footer Compliance -->
            <div class="px-8 py-5 bg-blue-50/50 border-t border-blue-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-[9px] font-black text-blue-400 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    Kepatuhan Keamanan Informasi BGN
                </div>
                <p class="text-[9px] text-slate-400 text-center font-bold">Terakhir diperbarui: {{ date('d M Y') }}</p>
            </div>
        </div>
    </section>

    <!-- Logos Section -->
    <section class="max-w-7xl mx-auto px-6 py-24 border-t border-slate-100">
        <div class="text-center mb-12">
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-400 mb-2">Didukung Oleh Lembaga Resmi</p>
            <div class="h-[1px] w-12 bg-[#D4AF37] mx-auto"></div>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-32">
            <div class="flex flex-col items-center gap-6 group text-center">
                <div class="p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-2xl shadow-slate-200/50 group-hover:shadow-blue-500/10 group-hover:border-blue-100 transition-all duration-500 transform group-hover:-translate-y-3 flex items-center justify-center">
                    <img src="{{ asset('images/bgn_logo.png') }}" alt="BGN" class="h-28 md:h-44 w-auto object-contain">
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-[10px] font-black tracking-[0.4em] text-slate-300 group-hover:text-blue-600 transition-colors uppercase">Lembaga Negara</span>
                    <span class="text-xs font-black tracking-widest text-[#0F172A] mt-1">BADAN GIZI NASIONAL</span>
                </div>
            </div>
            <div class="flex flex-col items-center gap-6 group text-center">
                <div class="p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-2xl shadow-slate-200/50 group-hover:shadow-red-500/10 group-hover:border-red-100 transition-all duration-500 transform group-hover:-translate-y-3 flex items-center justify-center">
                    <img src="{{ asset('images/ala_delphi.png') }}" alt="Yayasan ALA DELPHI" class="h-28 md:h-44 w-auto object-contain">
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-[10px] font-black tracking-[0.4em] text-slate-300 group-hover:text-red-600 transition-colors uppercase">Yayasan Pendidikan</span>
                    <span class="text-xs font-black tracking-widest text-[#0F172A] mt-1">YAYASAN ALA DELPHI</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="relative rounded-[3rem] overflow-hidden hero-gradient p-12 lg:p-24 text-center">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-[#D4AF37]/20 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] translate-x-1/3 translate-y-1/3"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto">
                <span class="inline-block px-4 py-1 rounded-full bg-white/10 text-[#D4AF37] font-black text-xs uppercase tracking-[0.3em] mb-8 border border-white/5">Misi Besar Dimulai</span>
                <h2 class="playfair text-4xl lg:text-6xl font-black italic text-white leading-tight mb-8">
                    BoTo Delphi Telah <br> <span class="text-[#D4AF37]">Siap Beraksi.</span>
                </h2>
                <p class="text-slate-300 text-lg mb-12 leading-relaxed">
                    Kami telah menyelesaikan pengembangan platform integrasi gizi ini. Sekarang saatnya Anda menjadi bagian dari perubahan untuk masa depan generasi emas Indonesia 2045.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-10 py-5 rounded-2xl bg-[#D4AF37] text-white font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-gold/20 hover:scale-105 hover:bg-white hover:text-[#0F172A] transition-all duration-300">
                            Masuk ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login.wa') }}" class="px-10 py-5 rounded-2xl bg-[#D4AF37] text-white font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-gold/20 hover:scale-105 hover:bg-white hover:text-[#0F172A] transition-all duration-300">
                            Mulai Sekarang (WA)
                        </a>
                        <a href="{{ route('suppliers.register') }}" class="px-10 py-5 rounded-2xl border border-white/20 text-white font-black text-xs tracking-[0.2em] uppercase hover:bg-white/10 transition-all duration-300">
                            Daftar Pemasok
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Floating Elements for "Premium" feel -->
            <div class="hidden lg:block absolute left-20 bottom-20 animate-bounce transition-all duration-[3000ms]">
                <div class="glass p-4 rounded-2xl border-white/10 shadow-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white text-[10px] font-black uppercase tracking-widest">Status Sistem</p>
                            <p class="text-green-400 text-xs font-bold uppercase tracking-widest">100% Operasional</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0F172A] text-white py-24">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-8">
                    <x-application-logo class="w-12 h-auto invert" />
                    <span class="playfair font-black italic text-3xl tracking-tighter">BoTo Delphi</span>
                </div>
                <p class="text-slate-400 max-w-sm mb-8 leading-relaxed">Platform Integrasi Manajemen Gizi Terpadu untuk Masa Depan Indonesia yang Lebih Baik.</p>
                <div class="space-y-6">
                    <h4 class="font-black uppercase tracking-[0.3em] text-[10px] text-[#D4AF37]">Kanal Komunikasi Resmi</h4>
                    <div class="flex flex-col gap-4">
                        <a href="https://www.facebook.com/share/1AbUNqfxC8/" target="_blank" class="flex items-center group transition-all duration-300">
                            <div class="w-10 h-10 rounded-xl bg-slate-800/50 border border-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-[#D4AF37] group-hover:text-white transition-all duration-300 shadow-lg">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <span class="ml-4 text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-[#D4AF37] transition-all">Facebook Resmi</span>
                        </a>
                        <a href="https://youtube.com/@koransimantab?si=RiKlfKBxduXrqDg1" target="_blank" class="flex items-center group transition-all duration-300">
                            <div class="w-10 h-10 rounded-xl bg-slate-800/50 border border-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-[#D4AF37] group-hover:text-white transition-all duration-300 shadow-lg">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.377.505 9.377.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </div>
                            <span class="ml-4 text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-[#D4AF37] transition-all">Saluran YouTube</span>
                        </a>
                        <a href="#" class="flex items-center group transition-all duration-300">
                            <div class="w-10 h-10 rounded-xl bg-slate-800/50 border border-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-[#D4AF37] group-hover:text-white transition-all duration-300 shadow-lg">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                            <span class="ml-4 text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-[#D4AF37] transition-all">Instagram Resmi</span>
                        </a>
                    </div> </div>
            </div>
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-[#D4AF37] mb-8">Tautan Cepat</h4>
                <ul class="space-y-4 text-slate-400 text-sm font-medium">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition-all">Beranda</a></li>
                    <li><a href="{{ route('kitchens.index') }}" class="hover:text-white transition-all">Profil Dapur</a></li>
                    <li><a href="{{ route('prices.index') }}" class="hover:text-white transition-all">Harga Pangan</a></li>
                    <li><a href="{{ route('community-prices.index') }}" class="hover:text-white transition-all">Harga Komunitas</a></li>
                    <li><a href="{{ route('complaints.create') }}" class="hover:text-white transition-all">Aduan Publik</a></li>
                    <li><a href="https://siperda.simalungunkab.go.id" target="_blank" class="hover:text-white transition-all">Siperda Simalungun ↗</a></li>
                    <li><a href="https://bgn.go.id" target="_blank" class="hover:text-white transition-all">BGN.go.id ↗</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-[#D4AF37] mb-8">Kontak</h4>
                <ul class="space-y-4 text-slate-400 text-sm font-medium">
                    <li>Jl. Gizi Sejahtera No. 45, Jakarta Selatan</li>
                    <li>support@botodelpi.com</li>
                    <li>+62 853 5332 5352</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-12 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6 text-slate-500 text-xs font-black tracking-[0.4em] uppercase">
            <p>&copy; 2026 BOTO DELPHI MBG FOUNDATION HUB. ALL RIGHTS RESERVED.</p>
            <div class="flex gap-8">
                <a href="#">Privasi</a>
                <a href="#">Ketentuan</a>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp CTA -->
    <div class="fixed bottom-8 right-8 z-[60] group">
        <a href="https://wa.me/6285353325352?text=Halo%20Mas%2C%20saya%20ingin%20tanya%20tentang%20proyek%20BoTo%20Delphi" target="_blank" 
           class="flex items-center gap-4 bg-white/10 backdrop-blur-xl border border-white/20 p-2 pr-6 rounded-full shadow-2xl hover:bg-[#D4AF37] transition-all duration-500 group">
            <div class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-500">
                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-[10px] font-black uppercase tracking-widest text-[#D4AF37] group-hover:text-white transition-colors">Tanya Sesuatu?</span>
                <span class="text-sm font-bold text-[#0F172A] group-hover:text-white transition-colors">Hubungi Mas Admin</span>
            </div>
        </a>
    </div>

</body>
</html>
