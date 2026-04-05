<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Pemasok - MBG Foundation Hub</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4AF37',
                        'gold-dark': '#B8860B',
                        'navy': '#0F172A',
                    },
                    fontFamily: {
                        'playfair': ['"Playfair Display"', 'serif'],
                        'sans': ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .hero-gradient {
            background: radial-gradient(circle at top right, #1E293B 0%, #0F172A 100%);
        }
        input:focus, select:focus, textarea:focus {
            outline: none !important;
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1) !important;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #F1F5F9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans text-navy min-h-screen flex items-center justify-center p-4 md:p-8">

    <div class="max-w-2xl w-full">
        <!-- Main Card -->
        <div class="bg-white rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(15,23,42,0.15)] overflow-hidden border border-slate-100 flex flex-col relative">
            
            <!-- Top Accents -->
            <div class="h-2 w-full bg-gradient-to-r from-gold via-gold-dark to-gold"></div>

            <div class="p-8 md:p-14">
                <!-- Header Branding -->
                <div class="flex flex-col items-center mb-12">
                    <div class="flex items-center gap-6 mb-8">
                        <img src="{{ asset('images/bgn_logo.png') }}" alt="BGN" class="h-14 w-auto drop-shadow-sm">
                        <div class="h-10 w-[1px] bg-slate-200"></div>
                        <img src="{{ asset('images/ala_delphi.png') }}" alt="ALA DELPHI" class="h-14 w-auto drop-shadow-sm">
                    </div>
                    
                    <div class="text-center">
                        <h1 class="font-playfair italic font-black text-4xl text-navy mb-3">Daftar Pemasok Resmi</h1>
                        <div class="flex items-center justify-center gap-3">
                            <span class="h-[1px] w-8 bg-gold/50"></span>
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.5em] text-gold">MBG Foundation Hub</p>
                            <span class="h-[1px] w-8 bg-gold/50"></span>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                <div class="mb-10 p-5 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
                    <div class="h-12 w-12 bg-emerald-500 rounded-full flex items-center justify-center shrink-0 shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-emerald-900 leading-tight">Pendaftaran Berhasil!</p>
                        <p class="text-sm text-emerald-700/80">Data Anda telah kami terima dan akan segera diproses.</p>
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('suppliers.register.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <!-- Nama -->
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 ml-1 group-focus-within:text-gold transition-colors">Identitas Pemasok / Usaha</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <span class="text-[10px] font-bold text-gold border-r border-slate-200 pr-3">NAMA</span>
                            </div>
                            <input type="text" name="name" required class="w-full pl-20 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-navy transition-all placeholder:text-slate-300" placeholder="Contoh: UD. Tani Maju Sejahtera">
                        </div>
                    </div>

                    <!-- Grid for Loc & WA -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 ml-1 group-focus-within:text-gold transition-colors">Wilayah Operasional</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <span class="text-[10px] font-bold text-gold border-r border-slate-200 pr-3">DESA</span>
                                </div>
                                <input type="text" name="village" required class="w-full pl-20 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-navy transition-all placeholder:text-slate-300" placeholder="Nama Desa/Kecamatan">
                            </div>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 ml-1 group-focus-within:text-gold transition-colors">Kontak WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <span class="text-[10px] font-bold text-gold border-r border-slate-200 pr-3">W/A</span>
                                </div>
                                <input type="text" name="phone" required class="w-full pl-20 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-navy transition-all placeholder:text-slate-300" placeholder="0812xxxx">
                            </div>
                        </div>
                    </div>

                    <!-- SPPG Target -->
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 ml-1 group-focus-within:text-gold transition-colors">Dapur (SPPG) Yang Dituju</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <span class="text-[10px] font-bold text-gold border-r border-slate-200 pr-3">DPR</span>
                            </div>
                            <select name="sppg_id" required class="w-full pl-20 pr-10 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-navy appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Lokasi Dapur Terdekat</option>
                                @foreach($sppgs as $sppg)
                                    <option value="{{ $sppg->id }}">{{ $sppg->name }} ({{ $sppg->location }})</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Commodities -->
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 ml-1 group-focus-within:text-gold transition-colors">Komoditas / Barang Yang Tersedia</label>
                        <textarea name="items" rows="4" class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-navy transition-all placeholder:text-slate-300 custom-scrollbar" placeholder="Sebutkan barang yang ingin Anda suplai (Misal: Daging Ayam, Telur, Beras, Sayuran Segar, dll)"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 hero-gradient text-white rounded-[1.5rem] font-extrabold text-[11px] tracking-[0.3em] uppercase shadow-2xl shadow-navy/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-4">
                            <span>Kirim Data Pendaftaran</span>
                            <div class="h-10 w-[1px] bg-white/20"></div>
                            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </form>

                <!-- Back Link -->
                <div class="mt-12 text-center">
                    <a href="/" class="text-[10px] font-black text-slate-300 hover:text-gold transition-all tracking-[0.3em] uppercase">Kembali ke Beranda Utama</a>
                </div>
            </div>
        </div>

        <!-- Footer Copyright -->
        <p class="text-center mt-12 text-[10px] font-bold text-slate-300 uppercase tracking-widest">
            &copy; 2026 MBG Logistics Hub &bull; Membangun Rantai Pasok Gizi Berkualitas
        </p>
    </div>

</body>
</html>
