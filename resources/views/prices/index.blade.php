<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transparansi Harga Pangan - BoTo Delphi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .playfair { font-family: 'Playfair Display', serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="antialiased text-slate-900">

    <nav class="p-6 max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <x-application-logo class="w-10 h-auto" />
            <span class="playfair font-black italic text-xl tracking-tighter">BoTo Delphi</span>
        </a>
        <a href="{{ url('/') }}" class="text-sm font-bold text-slate-500 hover:text-slate-900 transition-all">← Kembali ke Beranda</a>
    </nav>

    <header class="max-w-7xl mx-auto px-6 py-12 text-center">
        <span class="inline-block px-4 py-1 rounded-full bg-emerald-100 text-emerald-700 font-black text-xs uppercase tracking-widest mb-4">Live Transparency Feed</span>
        <h1 class="playfair text-4xl lg:text-6xl font-black italic mb-6 text-slate-900">Transparansi Harga Pangan</h1>
        <p class="text-slate-500 max-w-2xl mx-auto text-lg">Kami membuka data pembelian bahan baku langsung dari tingkat petani dan supplier untuk memastikan akuntabilitas publik dan keadilan harga bagi produsen lokal.</p>
    </header>

    <main class="max-w-7xl mx-auto px-6 pb-24">
        <div class="glass rounded-[2rem] overflow-hidden border border-slate-200 shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white uppercase text-xs tracking-[0.2em] font-black">
                            <th class="p-6">Nama Bahan Baku</th>
                            <th class="p-6">Kategori</th>
                            <th class="p-6">Satuan</th>
                            <th class="p-6">Dapur Pengelola (SPPG)</th>
                            <th class="p-6 text-right">Harga Referensi (Terakhir)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white/50">
                        @forelse($prices as $material)
                        <tr class="hover:bg-slate-50 transition-all">
                            <td class="p-6">
                                <div class="font-black text-slate-900 uppercase tracking-tight">{{ $material->name }}</div>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase">{{ $material->category }}</span>
                            </td>
                            <td class="p-6 text-sm font-bold text-slate-500">{{ $material->unit ?? '-' }}</td>
                            <td class="p-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-sm font-bold text-slate-700">{{ $material->sppg->name ?? 'Pusat (Inter-SPPG)' }}</span>
                                </div>
                            </td>
                            <td class="p-6 text-right">
                                @php
                                    $displayPrice = $material->last_price > 0 ? $material->last_price : $material->price;
                                @endphp
                                <div class="font-black text-xl text-slate-900 tracking-tighter">
                                    Rp {{ number_format($displayPrice, 0, ',', '.') }}
                                    <span class="text-[10px] text-slate-400 font-bold uppercase ml-1">/ {{ $material->unit ?? 'Unit' }}</span>
                                </div>
                                <div class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mt-1">Verified Real-Time</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center text-slate-400 font-medium whitespace-pre-line">
                                <div class="text-4xl mb-4">🔍</div>
                                Belum ada data referensi harga bahan baku yang tersedia saat ini.
                                Administrasi SPPG sedang mensinkronkan data katalog.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($prices->hasPages())
            <div class="p-6 bg-slate-50 border-t border-slate-200">
                {{ $prices->links() }}
            </div>
            @endif
        </div>

        <!-- Call to Action -->
        <div class="mt-12 text-center">
            <p class="text-slate-400 text-sm font-semibold mb-6 uppercase tracking-widest">Punya pertanyaan tentang harga?</p>
            <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-3 px-8 py-4 hero-gradient rounded-xl text-white font-black text-xs tracking-widest uppercase shadow-xl hover:scale-105 transition-all bg-slate-900">
                Laporkan Ketidaksesuaian Harga
            </a>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-12 mt-24">
        <div class="max-w-7xl mx-auto px-6 text-center text-slate-400 text-xs font-black tracking-widest uppercase">
            &copy; 2026 BOTO DELPHI - MBG FOUNDATION HUB. SEMUA DATA BERSIFAT RIIL DAN DAPAT DIPERCOYA.
        </div>
    </footer>

</body>
</html>
