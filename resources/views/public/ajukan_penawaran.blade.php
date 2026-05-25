<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Penawaran Bahan | Alad Elphi MBG</title>
    <meta name="description" content="Ajukan penawaran bahan baku untuk Program Makan Bergizi Gratis (MBG) Yayasan Alad Elphi.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,900&family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #0F172A;
            --accent: #D4AF37;
            --glass: rgba(255, 255, 255, 0.85);
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
            background-image: radial-gradient(circle at 80% 10%, rgba(212,175,55,0.05) 0%, transparent 50%),
                              radial-gradient(circle at 10% 90%, rgba(15,23,42,0.03) 0%, transparent 50%);
        }
        .playfair { font-family: 'Playfair Display', serif; }
        .glass { background: var(--glass); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.4); }
        .hero-gradient { background: linear-gradient(135deg, #0F172A 0%, #1e293b 100%); }
        .input-field {
            width: 100%; padding: 12px 18px;
            background: #F8FAFC; border: 2px solid #E2E8F0;
            border-radius: 14px; font-size: 14px; font-weight: 600;
            color: #0F172A; font-family: 'Inter', sans-serif;
            transition: border-color .2s, box-shadow .2s; outline: none;
        }
        .input-field:focus { border-color: #D4AF37; box-shadow: 0 0 0 3px rgba(212,175,55,0.15); }
        .label { display: block; font-size: 10px; font-weight: 900; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 6px; }

        /* Ticker Styles */
        .ticker-container {
            width: 100%;
            overflow: hidden;
            background: #0F172A;
            height: 44px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid rgba(212,175,55,0.2);
        }
        .ticker-header {
            background: #D4AF37;
            color: #0F172A;
            padding: 0 20px;
            height: 100%;
            display: flex;
            align-items: center;
            font-weight: 900;
            font-size: 11px;
            letter-spacing: 0.2em;
            z-index: 2;
            position: relative;
            box-shadow: 10px 0 30px rgba(0,0,0,0.3);
            flex-shrink: 0;
        }
        .ticker-header::after {
            content: '';
            position: absolute;
            right: -15px;
            top: 0;
            border-left: 15px solid #D4AF37;
            border-bottom: 44px solid transparent;
        }
        .ticker-content-wrap {
            flex: 1;
            overflow: hidden;
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }
        .ticker-content-wrap::before,
        .ticker-content-wrap::after {
            content: '';
            position: absolute;
            top: 0;
            width: 60px;
            height: 100%;
            z-index: 1;
        }
        .ticker-content-wrap::before {
            left: 0;
            background: linear-gradient(to right, #0F172A 0%, transparent 100%);
        }
        .ticker-content-wrap::after {
            right: 0;
            background: linear-gradient(to left, #0F172A 0%, transparent 100%);
        }
        .ticker-track {
            display: inline-block;
            white-space: nowrap;
            padding-right: 100%;
            animation: ticker-premium 70s linear infinite;
        }
        .ticker-item {
            display: inline-flex;
            align-items: center;
            padding: 0 40px;
            color: rgba(255,255,255,0.8);
            font-size: 13px;
        }
        .ticker-label {
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 11px;
            margin-right: 12px;
            padding: 2px 10px;
            border-radius: 4px;
            background: rgba(255,255,255,0.05);
        }
        .ticker-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: currentColor;
            margin-right: 8px;
            display: inline-block;
        }
        .ticker-item strong {
            color: #fff;
            font-weight: 700;
        }
        @keyframes ticker-premium {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }

        /* Success overlay */
        #success-overlay { display:none; position:fixed; inset:0; background:rgba(15,23,42,0.85); z-index:999; align-items:center; justify-content:center; }
        #success-overlay.show { display:flex; }

        .animate-pulse-slow { animation: pulse 3s cubic-bezier(0.4,0,0.6,1) infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.7} }
    </style>
</head>
<body class="antialiased">

<!-- Premium News Ticker -->
@php
    $latest_news = \App\Models\News::latest()->take(3)->get()->map(function($item) {
        return [
            'type' => 'news',
            'label' => 'Berita',
            'color' => '#3b82f6',
            'content' => "<strong>" . $item->title . "</strong> baru saja diupload",
            'created_at' => $item->created_at
        ];
    });
    
    $latest_suppliers = \App\Models\Supplier::latest()->take(3)->get()->map(function($item) {
        return [
            'type' => 'supplier',
            'label' => 'Pemasok',
            'color' => '#10b981',
            'content' => "<strong>" . $item->name . "</strong> baru saja mendaftar jadi pemasok",
            'created_at' => $item->created_at
        ];
    });

    $latest_complaints = \App\Models\Complaint::latest()->take(3)->get()->map(function($item) {
        return [
            'type' => 'complaint',
            'label' => 'Pengaduan',
            'color' => '#f59e0b',
            'content' => "Input aduan diterima dari <strong>" . ($item->name ?? 'Anonim') . "</strong>",
            'created_at' => $item->created_at
        ];
    });

    $latest_consultations = \App\Models\NutritionConsultation::latest()->take(3)->get()->map(function($item) {
        return [
            'type' => 'nutrition',
            'label' => 'Konsul Gizi',
            'color' => '#8b5cf6',
            'content' => "<strong>" . $item->name . "</strong> mengisi jadwal konsultasi",
            'created_at' => $item->created_at
        ];
    });

    $ticker_items = collect()
        ->concat($latest_news)
        ->concat($latest_suppliers)
        ->concat($latest_complaints)
        ->concat($latest_consultations)
        ->sortByDesc('created_at')
        ->take(10);
@endphp

@if($ticker_items->count() > 0)
<div class="ticker-container">
    <div class="ticker-header">
        <span class="animate-pulse-slow">UPDATE TERKINI</span>
    </div>
    <div class="ticker-content-wrap">
        <div class="ticker-track">
            @foreach($ticker_items as $item)
                <div class="ticker-item">
                    <span class="ticker-label" style="color: {{ $item['color'] }}; background: {{ $item['color'] }}15">
                        <span class="ticker-dot"></span> {{ $item['label'] }}
                    </span>
                    <span>{!! $item['content'] !!}</span>
                </div>
            @endforeach
            {{-- Duplicate for seamless loop --}}
            @foreach($ticker_items as $item)
                <div class="ticker-item">
                    <span class="ticker-label" style="color: {{ $item['color'] }}; background: {{ $item['color'] }}15">
                        <span class="ticker-dot"></span> {{ $item['label'] }}
                    </span>
                    <span>{!! $item['content'] !!}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Navbar -->
<nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
    <div class="flex items-center gap-6">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#0F172A] rounded-xl flex items-center justify-center text-[#D4AF37] font-black text-xl italic shadow-lg shadow-[#0F172A]/20">B</div>
            <span class="playfair font-black italic text-2xl tracking-tighter text-[#0F172A]">BoTo Delphi</span>
        </a>
        <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>
        <div class="flex items-center gap-4 hidden md:flex opacity-80 transition-opacity hover:opacity-100">
            <a href="https://bgn.go.id" target="_blank" rel="noopener">
                <img src="{{ asset('images/bgn_logo.png') }}" alt="Badan Gizi Nasional" class="h-10 w-auto hover:opacity-100 opacity-80 transition-opacity">
            </a>
            <img src="{{ asset('images/ala_delphi.png') }}" alt="Yayasan ALA DELPHI" class="h-10 w-auto">
        </div>
    </div>
    <div class="flex gap-4">
        <a href="/" class="px-6 py-2 rounded-full border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">← Kembali ke Beranda</a>
    </div>
</nav>

<!-- Hero -->
<div class="hero-gradient py-14 px-6 text-center relative overflow-hidden">
    <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-96 h-96 bg-[#D4AF37]/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="relative z-10 max-w-2xl mx-auto">
        <span class="inline-block px-4 py-1 rounded-full bg-[#D4AF37]/20 border border-[#D4AF37]/40 text-[#D4AF37] font-black text-[10px] uppercase tracking-widest mb-5">🤝 Mitra Pemasok MBG</span>
        <h1 class="playfair text-4xl lg:text-5xl font-black italic text-white leading-tight mb-3">
            Ajukan <span class="text-[#D4AF37]">Penawaran</span> Anda
        </h1>
        <p class="text-white/50 text-sm font-medium max-w-md mx-auto">
            Isi form di bawah ini. Penawaran Anda akan otomatis terkirim via WhatsApp ke tim pengadaan kami.
        </p>
        @if($nextMenuDate)
        <div class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 border border-white/20 rounded-full">
            <span class="text-white/70 text-xs font-bold">Kebutuhan untuk tanggal:</span>
            <span class="text-[#D4AF37] font-black text-sm">{{ \Carbon\Carbon::parse($nextMenuDate)->translatedFormat('l, d F Y') }}</span>
        </div>
        @endif
    </div>
</div>

<!-- Main Form -->
<div class="max-w-5xl mx-auto px-6 py-12 pb-24">
    <div class="grid lg:grid-cols-5 gap-8">

        <!-- Left: Daftar Kebutuhan -->
        @if(count($requirements) > 0)
        <div class="lg:col-span-2">
            <div class="glass bg-white rounded-[2rem] p-7 border border-slate-100 shadow-xl sticky top-24">
                <div class="flex items-center gap-2 mb-5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#D4AF37]"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kebutuhan Bahan</span>
                </div>
                <h3 class="playfair text-xl font-black italic text-[#0F172A] mb-1">Daftar Bahan Dibutuhkan</h3>
                <p class="text-xs text-slate-400 font-medium mb-5">{{ \Carbon\Carbon::parse($nextMenuDate)->translatedFormat('l, d F Y') }}</p>
                <div class="space-y-2 max-h-96 overflow-y-auto pr-1">
                    @foreach($requirements as $req)
                    <div class="flex items-center justify-between px-3 py-2.5 bg-slate-50 border border-slate-100 rounded-xl hover:border-[#D4AF37]/40 transition-colors">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#D4AF37] shrink-0"></span>
                            <span class="text-sm font-bold text-[#0F172A]">{{ $req['name'] }}</span>
                        </div>
                        <span class="text-xs font-black text-[#B8860B] bg-[#D4AF37]/10 px-2 py-0.5 rounded-full whitespace-nowrap">{{ number_format($req['quantity'], 0, ',', '.') }} {{ $req['unit'] }}</span>
                    </div>
                    @endforeach
                </div>
                <p class="text-[10px] text-slate-400 font-medium mt-4 text-center">Pilih produk yang ingin Anda tawarkan di form sebelah →</p>
            </div>
        </div>
        @endif

        <!-- Right: Form -->
        <div class="{{ count($requirements) > 0 ? 'lg:col-span-3' : 'lg:col-span-5' }}">
            <div class="glass bg-white rounded-[2rem] p-8 md:p-10 border border-slate-100 shadow-2xl shadow-slate-200/50 relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#D4AF37]/8 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <span class="inline-block px-4 py-1 rounded-full bg-[#D4AF37]/10 text-[#B8860B] font-black text-[10px] uppercase tracking-widest mb-4">Form Penawaran</span>
                    <h2 class="playfair text-2xl lg:text-3xl font-black italic text-[#0F172A] mb-1">Data Diri & Penawaran</h2>
                    <p class="text-gray-400 text-sm mb-8">Semua field bertanda * wajib diisi.</p>

                    <form id="offerForm" class="space-y-5">
                        <div class="grid md:grid-cols-2 gap-5">
                            <!-- Nama PIC -->
                            <div>
                                <label class="label">Nama PIC *</label>
                                <input type="text" id="pic_name" placeholder="Nama lengkap Anda" required class="input-field">
                            </div>
                            <!-- Nama Usaha -->
                            <div>
                                <label class="label">Nama Usaha (opsional)</label>
                                <input type="text" id="business_name" placeholder="Toko / CV / PT ...">
                                <style>#business_name{width:100%;padding:12px 18px;background:#F8FAFC;border:2px solid #E2E8F0;border-radius:14px;font-size:14px;font-weight:600;color:#0F172A;font-family:'Inter',sans-serif;transition:border-color .2s,box-shadow .2s;outline:none;}#business_name:focus{border-color:#D4AF37;box-shadow:0 0 0 3px rgba(212,175,55,0.15);}</style>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-5">
                            <!-- No HP -->
                            <div>
                                <label class="label">No. HP / WhatsApp *</label>
                                <input type="tel" id="phone" placeholder="08xxxxxxxxxx" required class="input-field">
                            </div>
                            <!-- Alamat -->
                            <div>
                                <label class="label">Alamat *</label>
                                <input type="text" id="address" placeholder="Desa / Kelurahan, Kecamatan" required class="input-field">
                            </div>
                        </div>

                        <!-- Produk -->
                        <div>
                            <label class="label">Produk yang Ditawarkan *</label>
                            <select id="product" required class="input-field" style="cursor:pointer;">
                                <option value="">-- Pilih Bahan Baku --</option>
                                @foreach($requirements as $req)
                                    <option value="{{ $req['name'] }}" data-unit="{{ $req['unit'] }}" data-needed="{{ number_format($req['quantity'], 0, ',', '.') }} {{ $req['unit'] }}">
                                        {{ $req['name'] }} (dibutuhkan: {{ number_format($req['quantity'], 0, ',', '.') }} {{ $req['unit'] }})
                                    </option>
                                @endforeach
                                @if(count($requirements) > 0)
                                <option disabled>── Produk Lain ──</option>
                                @endif
                                @foreach($materials as $mat)
                                    @php $alreadyListed = collect($requirements)->contains('name', $mat->name); @endphp
                                    @if(!$alreadyListed)
                                    <option value="{{ $mat->name }}" data-unit="{{ $mat->unit ?? '' }}">{{ $mat->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="grid md:grid-cols-2 gap-5">
                            <!-- Harga Penawaran -->
                            <div>
                                <label class="label">Harga Penawaran *</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-black text-slate-400">Rp</span>
                                    <input type="number" id="price" placeholder="0" required min="0" class="input-field" style="padding-left:40px;">
                                </div>
                                <p class="text-[10px] text-slate-400 font-medium mt-1" id="price_unit_hint">Harga per satuan</p>
                            </div>
                            <!-- Qty Tersedia -->
                            <div>
                                <label class="label">Qty Tersedia *</label>
                                <div class="flex gap-2">
                                    <input type="number" id="qty" placeholder="0" required min="0" class="input-field" style="flex:1;">
                                    <input type="text" id="unit_display" placeholder="Satuan" class="input-field" style="width:90px;" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label class="label">Catatan Tambahan (opsional)</label>
                            <textarea id="notes" rows="3" placeholder="Contoh: Bisa antar langsung, tersedia setiap hari, dll..." class="input-field resize-none"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" id="submitBtn"
                                class="w-full py-5 bg-[#0F172A] text-white font-black text-xs tracking-[0.2em] uppercase rounded-2xl shadow-2xl shadow-slate-900/20 hover:bg-[#D4AF37] transition-all duration-300 flex items-center justify-center gap-3 group">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                Kirim Penawaran via WhatsApp
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </button>
                            <p class="text-[10px] text-slate-400 text-center mt-3 font-medium">Penawaran akan dikirim ke tim pengadaan via WhatsApp secara otomatis</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Overlay -->
<div id="success-overlay">
    <div class="bg-white rounded-[2rem] p-10 max-w-md w-full mx-6 text-center shadow-2xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#D4AF37]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="playfair text-2xl font-black italic text-[#0F172A] mb-2">Penawaran Terkirim! 🎉</h3>
        <p class="text-gray-400 text-sm mb-6">WhatsApp ke admin pertama sudah terbuka. Klik tombol di bawah untuk mengirim ke admin kedua juga.</p>
        <button id="sendSecond"
            class="w-full py-4 bg-[#0F172A] text-white font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-[#D4AF37] transition-all duration-300 flex items-center justify-center gap-2 mb-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
            Kirim ke Admin 2 (085355039822)
        </button>
        <a href="/" class="block text-sm font-bold text-slate-400 hover:text-[#0F172A] transition-colors">Kembali ke Beranda →</a>
    </div>
</div>

<!-- Footer -->
<footer class="bg-[#0F172A] text-white py-10">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-[#D4AF37]/10 rounded-xl flex items-center justify-center text-[#D4AF37] font-black text-lg italic">B</div>
            <span class="playfair font-black italic text-lg text-white">BoTo Delphi</span>
        </div>
        <p class="text-white/40 text-xs font-bold text-center">© {{ date('Y') }} Program MBG — Yayasan Alad Elphi & Badan Gizi Nasional</p>
        <a href="/jadwal-menu" class="text-[#D4AF37] text-xs font-bold hover:text-white transition-colors">Lihat Jadwal Menu →</a>
    </div>
</footer>

<script>
    // Update unit saat produk dipilih
    document.getElementById('product').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const unit = selected.getAttribute('data-unit') || '';
        const needed = selected.getAttribute('data-needed') || '';
        document.getElementById('unit_display').value = unit;
        document.getElementById('price_unit_hint').textContent = unit ? `Harga per ${unit}` : 'Harga per satuan';
    });

    let waMessage = '';

    document.getElementById('offerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const pic   = document.getElementById('pic_name').value.trim();
        const biz   = document.getElementById('business_name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const addr  = document.getElementById('address').value.trim();
        const prod  = document.getElementById('product').value.trim();
        const price = document.getElementById('price').value.trim();
        const qty   = document.getElementById('qty').value.trim();
        const unit  = document.getElementById('unit_display').value.trim();
        const notes = document.getElementById('notes').value.trim();

        if (!pic || !phone || !addr || !prod || !price || !qty) {
            alert('Harap lengkapi semua field yang wajib diisi (*)');
            return;
        }

        // Kirim data pendaftaran ke database secara asinkron (AJAX)
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', biz ? `${pic} (${biz})` : pic);
        formData.append('phone', phone);
        formData.append('village', addr);
        formData.append('items', `${prod} (Penawaran: Rp ${Number(price).toLocaleString('id-ID')}/${unit || 'satuan'}, Qty: ${qty} ${unit}${notes ? `, Catatan: ${notes}` : ''})`);

        fetch('{{ route("suppliers.register.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).catch(err => console.error('Gagal menyimpan pendaftaran ke sistem:', err));

        const tgl = '{{ $nextMenuDate ? \Carbon\Carbon::parse($nextMenuDate)->translatedFormat("l, d F Y") : "Segera" }}';

        waMessage =
`🤝 *PENAWARAN BAHAN BAKU MBG*
━━━━━━━━━━━━━━━━━━━━━
📅 Untuk tanggal: ${tgl}

👤 *Nama PIC:* ${pic}
${biz ? `🏪 *Nama Usaha:* ${biz}\n` : ''}📱 *No. HP:* ${phone}
📍 *Alamat:* ${addr}

📦 *Produk:* ${prod}
💰 *Harga Penawaran:* Rp ${Number(price).toLocaleString('id-ID')} / ${unit || 'satuan'}
📊 *Qty Tersedia:* ${qty} ${unit}
${notes ? `\n📝 *Catatan:* ${notes}` : ''}
━━━━━━━━━━━━━━━━━━━━━
Pesan ini dikirim otomatis dari portal aladelphi.or.id`;

        const wa1 = `https://wa.me/6285353325352?text=${encodeURIComponent(waMessage)}`;
        window.open(wa1, '_blank');

        document.getElementById('success-overlay').classList.add('show');
    });

    document.getElementById('sendSecond').addEventListener('click', function() {
        const wa2 = `https://wa.me/6285355039822?text=${encodeURIComponent(waMessage)}`;
        window.open(wa2, '_blank');
        this.textContent = '✅ Terkirim ke Admin 2!';
        this.disabled = true;
    });
</script>
</body>
</html>
