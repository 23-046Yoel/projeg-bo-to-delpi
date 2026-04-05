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
    @endphp
    @if($latest_news->count() > 0)
    <div class="ticker-wrap sticky top-0 z-50">
        <div class="ticker">
            @foreach($latest_news as $news)
                <span class="mx-8 font-semibold text-sm uppercase tracking-widest text-[#D4AF37]">
                    ● {{ $news->title }}
                </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Navbar -->
    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <x-application-logo class="w-12 h-auto" />
                <span class="playfair font-black italic text-2xl tracking-tighter text-[#0F172A]">BoTo Delphi</span>
            </div>
            <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>
            <div class="flex items-center gap-4 hidden md:flex opacity-80 transition-opacity hover:opacity-100">
                <img src="{{ asset('images/bgn_logo.png') }}" alt="Badan Gizi Nasional" class="h-10 w-auto">
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
            // Helper: extract YouTube ID
            function extractYoutubeId($url) {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url ?? '', $match);
                return $match[1] ?? null;
            }
        @endphp

        @if($dishVideos->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($dishVideos as $dish)
            @php $ytId = extractYoutubeId($dish->youtube_url); @endphp
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
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Price Card -->
            <div class="glass p-10 rounded-[2.5rem] border border-[#D4AF37]/30 bg-gradient-to-br from-white to-[#D4AF37]/5 flex flex-col justify-between">
                <div>
                    <h3 class="playfair text-2xl font-black italic text-[#0F172A] mb-4">Transparansi Harga Pangan</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed text-sm">Kami membuka data harga beli bahan baku langsung dari tingkat petani untuk memastikan tidak ada markup yang merugikan publik.</p>
                </div>
                <a href="{{ route('prices.index') }}" class="inline-block px-8 py-4 bg-[#D4AF37] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#B8860B] transition-all text-center">
                    Cek Harga Terkini
                </a>
            </div>

            <!-- Supplier Registration Card (Prominent) -->
            <div class="p-10 rounded-[2.5rem] bg-[#0F172A] border border-[#0F172A] shadow-2xl flex flex-col justify-between relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#D4AF37]/10 rounded-full blur-2xl group-hover:bg-[#D4AF37]/20 transition-all"></div>
                <div class="relative z-10">
                    <h3 class="playfair text-2xl font-black italic text-[#D4AF37] mb-4">Pendaftaran Pemasok Lokal</h3>
                    <p class="text-white/60 mb-8 leading-relaxed text-sm">Bergabunglah sebagai mitra penyuplai bahan baku segar. Dukung keberlanjutan pangan generasi emas Indonesia.</p>
                </div>
                <a href="{{ route('suppliers.register') }}" class="inline-block px-8 py-4 bg-[#D4AF37] text-[#0F172A] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-white transition-all text-center shadow-lg shadow-[#D4AF37]/20">
                    Daftar Sekarang
                </a>
            </div>

            <!-- Complaint Card -->
            <div class="glass p-10 rounded-[2.5rem] border border-red-100 bg-gradient-to-br from-white to-red-50 flex flex-col justify-between">
                <div>
                    <h3 class="playfair text-2xl font-black italic text-[#0F172A] mb-4">Layanan Pengaduan (Complaints)</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed text-sm">Ada masalah dengan kualitas makanan? Laporkan segera. Kami merespon laporan Anda dalam waktu maksimal 1x24 jam.</p>
                </div>
                <a href="{{ route('complaints.create') }}" class="inline-block px-8 py-4 bg-red-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-red-700 transition-all text-center">
                    Buat Laporan Baru
                </a>
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
            <div class="flex flex-col items-center gap-6 group">
                <div class="p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-2xl shadow-slate-200/50 group-hover:shadow-blue-500/10 group-hover:border-blue-100 transition-all duration-500 transform group-hover:-translate-y-3">
                    <img src="{{ asset('images/bgn_logo.png') }}" alt="BGN" class="h-28 md:h-44 w-auto">
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-[10px] font-black tracking-[0.4em] text-slate-300 group-hover:text-blue-600 transition-colors uppercase">Lembaga Negara</span>
                    <span class="text-xs font-black tracking-widest text-[#0F172A] mt-1">BADAN GIZI NASIONAL</span>
                </div>
            </div>
            <div class="flex flex-col items-center gap-6 group">
                <div class="p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-2xl shadow-slate-200/50 group-hover:shadow-red-500/10 group-hover:border-red-100 transition-all duration-500 transform group-hover:-translate-y-3">
                    <img src="{{ asset('images/ala_delphi.png') }}" alt="Yayasan ALA DELPHI" class="h-28 md:h-44 w-auto">
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-[10px] font-black tracking-[0.4em] text-slate-300 group-hover:text-red-600 transition-colors uppercase">Yayasan Pendidikan</span>
                    <span class="text-xs font-black tracking-widest text-[#0F172A] mt-1">YAYASAN ALA DELPHI</span>
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
                    <li><a href="#" class="hover:text-white transition-all">Beranda</a></li>
                    <li><a href="#stats" class="hover:text-white transition-all">Statistik Real-time</a></li>
                    <li><a href="{{ route('prices.index') }}" class="hover:text-white transition-all">Harga Pangan</a></li>
                    <li><a href="{{ route('complaints.create') }}" class="hover:text-white transition-all">Aduan Publik</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-[#D4AF37] mb-8">Kontak</h4>
                <ul class="space-y-4 text-slate-400 text-sm font-medium">
                    <li>Jl. Gizi Sejahtera No. 45, Jakarta Selatan</li>
                    <li>support@botodelpi.com</li>
                    <li>+62 857 6761 0448</li>
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

</body>
</html>
