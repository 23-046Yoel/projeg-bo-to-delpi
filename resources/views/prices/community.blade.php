<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Harga Pangan Komunitas - BoTo Delphi</title>
    <meta name="description" content="Laporan harga pangan terkini dari komunitas petani dan warga sekitar wilayah MBG.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F8FAFC; }
        .playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#0F172A] rounded-xl flex items-center justify-center text-[#D4AF37] font-black text-lg italic">B</div>
                <span class="playfair font-black italic text-xl text-[#0F172A]">BoTo Delphi</span>
            </a>
            <div class="flex gap-4">
                <a href="{{ route('prices.index') }}" class="text-xs font-black text-slate-500 hover:text-[#D4AF37] transition-colors uppercase tracking-widest">Harga Resmi</a>
                <a href="https://siperda.simalungunkab.go.id" target="_blank" class="text-xs font-black text-slate-500 hover:text-[#D4AF37] transition-colors uppercase tracking-widest">Siperda</a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-br from-[#0F172A] to-slate-800 py-16 text-center text-white">
        <span class="inline-block px-4 py-1 rounded-full bg-[#D4AF37]/20 text-[#D4AF37] font-black text-xs uppercase tracking-[0.3em] mb-4">Transparansi Harga Pangan</span>
        <h1 class="playfair text-4xl lg:text-5xl font-black italic leading-tight mb-3">Feed Harga <span class="text-[#D4AF37]">Komunitas</span></h1>
        <p class="text-slate-400 max-w-lg mx-auto">Laporan harga bahan pangan langsung dari warga, petani, dan pedagang pasar sekitar wilayah MBG.</p>
        <div class="mt-4">
            <a href="https://siperda.simalungunkab.go.id" target="_blank" class="inline-flex items-center gap-2 text-xs font-black text-emerald-400 uppercase tracking-widest hover:text-emerald-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Cek Harga Resmi di Siperda Simalungun ↗
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12 grid lg:grid-cols-3 gap-10">

        <!-- Submission Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-lg p-8 sticky top-24">
                <h2 class="playfair text-xl font-black italic text-[#0F172A] mb-2">Laporkan Harga</h2>
                <p class="text-xs text-slate-400 mb-6 leading-relaxed">Bantu komunitas dengan melaporkan harga bahan baku yang kamu tahu atau lihat di pasar.</p>

                @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-sm font-bold mb-6">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('community-prices.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-[#0F172A] uppercase tracking-[0.2em] mb-2">Nama Bahan Pangan *</label>
                        <input type="text" name="item_name" required placeholder="Contoh: Beras Putih" class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-[#0F172A] focus:bg-white focus:border-[#D4AF37] outline-none transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-[#0F172A] uppercase tracking-[0.2em] mb-2">Harga (Rp) *</label>
                            <input type="number" name="price" required placeholder="12000" class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-[#0F172A] focus:bg-white focus:border-[#D4AF37] outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-[#0F172A] uppercase tracking-[0.2em] mb-2">Satuan</label>
                            <select name="unit" class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-[#0F172A] focus:bg-white focus:border-[#D4AF37] outline-none transition-all">
                                <option value="kg">kg</option>
                                <option value="gram">gram</option>
                                <option value="liter">liter</option>
                                <option value="buah">buah</option>
                                <option value="ikat">ikat</option>
                                <option value="lusin">lusin</option>
                                <option value="karung">karung</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-[#0F172A] uppercase tracking-[0.2em] mb-2">Lokasi Pasar / Toko *</label>
                        <input type="text" name="location" required placeholder="Contoh: Pasar Tanah Jawa, Simalungun" class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-[#0F172A] focus:bg-white focus:border-[#D4AF37] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-[#0F172A] uppercase tracking-[0.2em] mb-2">Nama Anda (Opsional)</label>
                        <input type="text" name="reporter_name" placeholder="Anonim" class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-[#0F172A] focus:bg-white focus:border-[#D4AF37] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-[#0F172A] uppercase tracking-[0.2em] mb-2">No. HP (Opsional)</label>
                        <input type="text" name="reporter_phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-[#0F172A] focus:bg-white focus:border-[#D4AF37] outline-none transition-all">
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#0F172A] text-[#D4AF37] font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl shadow-slate-900/10 hover:bg-slate-800 hover:-translate-y-1 transition-all duration-300">
                        Kirim Laporan Harga
                    </button>
                </form>
            </div>
        </div>

        <!-- Price Feed -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-8">
                <h2 class="playfair text-2xl font-black italic text-[#0F172A]">Laporan Terbaru</h2>
                <span class="px-4 py-1.5 bg-[#0F172A]/5 text-[#0F172A] text-[10px] font-black rounded-full uppercase tracking-widest">{{ $prices->total() }} Laporan</span>
            </div>

            <div class="space-y-4">
                @forelse($prices as $price)
                <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-md p-6 hover:shadow-lg transition-shadow" id="price-{{ $price->id }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-2xl font-black text-[#D4AF37]">
                                {{ mb_substr($price->item_name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-black text-[#0F172A]">{{ $price->item_name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xl font-black text-[#D4AF37]">Rp {{ number_format($price->price, 0, ',', '.') }}</span>
                                    <span class="text-slate-400 text-sm font-bold">/ {{ $price->unit }}</span>
                                    @if($price->is_verified)
                                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-600 text-[10px] font-black rounded-full uppercase">✓ Terverifikasi</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Like Button -->
                        <button onclick="likePrice({{ $price->id }})" class="flex flex-col items-center gap-1 p-3 rounded-2xl border border-slate-100 hover:border-[#D4AF37] hover:bg-[#D4AF37]/5 transition-all group">
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-[#D4AF37] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span class="text-[10px] font-black text-slate-400 like-count-{{ $price->id }}">{{ $price->likes }}</span>
                        </button>
                    </div>
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-t border-slate-50 pt-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $price->location }}
                        </span>
                        <span>Oleh: {{ $price->reporter_name }}</span>
                        <span class="ml-auto">{{ $price->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-20 bg-white rounded-[2rem] border border-slate-100">
                    <p class="text-slate-400 font-bold">Belum ada laporan harga. Jadilah yang pertama!</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($prices->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $prices->links() }}
            </div>
            @endif
        </div>
    </div>

    <footer class="bg-[#0F172A] text-slate-400 text-center py-8 mt-12">
        <p class="text-xs font-bold uppercase tracking-widest">© 2026 BoTo Delphi MBG Foundation Hub</p>
    </footer>

    <script>
    async function likePrice(id) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const res = await fetch(`/harga-komunitas/${id}/like`, {
            method: 'POST', headers: { 'X-CSRF-TOKEN': token, 'Content-Type': 'application/json' }
        });
        const data = await res.json();
        document.querySelector(`.like-count-${id}`).textContent = data.likes;
    }
    </script>
</body>
</html>
