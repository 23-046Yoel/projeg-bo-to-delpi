<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $kitchen->name }} - Profil Dapur MBG</title>
    <meta name="description" content="Profil dapur SPPG {{ $kitchen->name }}, program Makan Bergizi Gratis (MBG) Yayasan Ala Delphi.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #F8FAFC; }
        .playfair { font-family: 'Playfair Display', serif; }
        .hero-grad { background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%); }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3 text-sm text-slate-400 font-bold">
                <a href="{{ url('/') }}" class="hover:text-[#D4AF37] transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('kitchens.index') }}" class="hover:text-[#D4AF37] transition-colors">Profil Dapur</a>
                <span>/</span>
                <span class="text-[#0F172A]">{{ $kitchen->name }}</span>
            </div>
            @auth
            <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-full bg-[#0F172A] text-white font-bold text-xs tracking-widest uppercase hover:scale-105 transition-all">Dashboard</a>
            @else
            <a href="{{ route('login.wa') }}" class="px-5 py-2 rounded-full border-2 border-[#0F172A] text-[#0F172A] font-bold text-xs tracking-widest uppercase hover:bg-[#0F172A] hover:text-white transition-all">Masuk</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Banner -->
    <div class="relative h-72 hero-grad overflow-hidden">
        @if($kitchen->image_path)
        <img src="{{ Storage::url($kitchen->image_path) }}" class="absolute inset-0 w-full h-full object-cover opacity-30" alt="{{ $kitchen->name }}">
        @endif
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6">
            <!-- Live / Closed Status -->
            <div class="mb-6">
                @if($isOperational)
                <span class="flex items-center gap-2 px-5 py-2 bg-emerald-500/20 border border-emerald-500/30 backdrop-blur rounded-full text-emerald-300 text-xs font-black uppercase tracking-[0.2em]">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    Dapur Sedang Aktif & Beroperasi
                </span>
                @else
                <span class="px-5 py-2 bg-slate-700/40 border border-slate-600/30 backdrop-blur rounded-full text-slate-400 text-xs font-black uppercase tracking-[0.2em]">
                    Dapur Sedang Tutup
                </span>
                @endif
            </div>
            <h1 class="playfair text-4xl lg:text-5xl font-black italic text-white leading-tight mb-3">{{ $kitchen->name }}</h1>
            @if($kitchen->address)
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $kitchen->address }}
            </p>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-6xl mx-auto px-6 py-16 grid lg:grid-cols-3 gap-10">

        <!-- Left: Info Cards -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Management Info -->
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-lg p-8">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4AF37] mb-6">Manajemen Dapur</h3>
                <div class="space-y-5">
                    @if($kitchen->manager_name)
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-2xl bg-[#0F172A] flex items-center justify-center text-white font-black text-lg">
                            {{ substr($kitchen->manager_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kepala SPPG</p>
                            <p class="font-black text-[#0F172A]">{{ $kitchen->manager_name }}</p>
                        </div>
                    </div>
                    @endif
                    @if($kitchen->contact_phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kitchen->contact_phone) }}" target="_blank"
                       class="flex items-center gap-3 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 hover:bg-emerald-500 hover:text-white group transition-all">
                        <svg class="w-5 h-5 text-emerald-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <div>
                            <p class="text-[10px] font-black text-emerald-700 group-hover:text-white uppercase tracking-widest">Kontak Dapur</p>
                            <p class="font-bold text-[#0F172A] group-hover:text-white text-sm">{{ $kitchen->contact_phone }}</p>
                        </div>
                    </a>
                    @endif
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jam Operasional</span>
                        <span class="text-sm font-black text-[#0F172A]">{{ $kitchen->operational_hours ?? '06:00 - 14:00' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gold/5 rounded-2xl border border-gold/10">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Staff Online Sekarang</span>
                        <span class="text-sm font-black text-[#D4AF37]">{{ $onlineUsers }} Orang</span>
                    </div>
                </div>
            </div>

            <!-- Beneficiary Summary -->
            <div class="bg-[#0F172A] rounded-[2rem] p-8 text-white">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4AF37] mb-6">Penerima Manfaat</h3>
                <div class="space-y-4">
                    @forelse($beneficiaryGroups->take(5) as $group)
                    <div class="flex items-center justify-between py-3 border-b border-white/5">
                        <div>
                            <p class="font-bold text-sm text-white leading-tight">{{ $group->name }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $group->type }}</p>
                        </div>
                        <span class="px-3 py-1 bg-[#D4AF37]/20 text-[#D4AF37] text-[10px] font-black rounded-xl">{{ $group->total_beneficiaries }} PM</span>
                    </div>
                    @empty
                    <p class="text-slate-500 text-sm">Belum ada data PM.</p>
                    @endforelse
                    @if($beneficiaryGroups->count() > 5)
                    <p class="text-[10px] text-slate-500 text-center pt-2">+{{ $beneficiaryGroups->count() - 5 }} lokasi lainnya</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Description & News Feed -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Description -->
            @if($kitchen->description)
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-lg p-8">
                <h2 class="playfair text-2xl font-black italic text-[#0F172A] mb-4">Tentang {{ $kitchen->name }}</h2>
                <p class="text-slate-600 leading-relaxed">{{ $kitchen->description }}</p>
            </div>
            @endif

            <!-- News Feed from this Kitchen -->
            @if($news->count() > 0)
            <div>
                <h2 class="playfair text-2xl font-black italic text-[#0F172A] mb-6">Dokumentasi Terbaru</h2>
                <div class="grid sm:grid-cols-2 gap-6">
                    @foreach($news as $post)
                    <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-md overflow-hidden group">
                        @if($post->image_path)
                        <div class="relative h-40 overflow-hidden">
                            <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        @endif
                        <div class="p-5">
                            <h3 class="font-black text-[#0F172A] text-sm mb-2 line-clamp-1">{{ $post->title }}</h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mb-3 leading-relaxed">{{ $post->content }}</p>
                            <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-widest">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-lg p-12 text-center">
                <svg class="w-12 h-12 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                <p class="text-slate-400 font-bold">Belum ada dokumentasi dari dapur ini.</p>
            </div>
            @endif

            <!-- External Reference links -->
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-lg p-8">
                <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#D4AF37] mb-6">Referensi Terkait</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <a href="https://bgn.go.id" target="_blank" class="flex items-center gap-3 p-4 border border-slate-100 rounded-2xl hover:border-blue-200 hover:bg-blue-50 group transition-all">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-500 transition-all">
                            <svg class="w-5 h-5 text-blue-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Situs Resmi</p>
                            <p class="font-black text-[#0F172A] text-sm">BGN.go.id</p>
                        </div>
                    </a>
                    <a href="https://siperda.simalungunkab.go.id" target="_blank" class="flex items-center gap-3 p-4 border border-slate-100 rounded-2xl hover:border-emerald-200 hover:bg-emerald-50 group transition-all">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-500 transition-all">
                            <svg class="w-5 h-5 text-emerald-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data Harga Pasar</p>
                            <p class="font-black text-[#0F172A] text-sm">Siperda Simalungun</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-[#0F172A] text-slate-400 text-center py-8">
        <p class="text-xs font-bold uppercase tracking-widest">© 2026 BoTo Delphi MBG Foundation Hub</p>
    </footer>

</body>
</html>
