<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pengaduan MBG - BoTo Delphi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .playfair { font-family: 'Playfair Display', serif; }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.5); }
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

    <main class="max-w-2xl mx-auto px-6 py-12">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 rounded-full bg-red-100 text-red-700 font-black text-xs uppercase tracking-widest mb-4">Layanan Pengaduan Publik</span>
            <h1 class="playfair text-4xl font-black italic mb-4">Laporkan Masalah</h1>
            <p class="text-slate-500">Kami berkomitmen memberikan layanan terbaik. Laporkan segala kendala terkait kualitas makanan, pengiriman, atau layanan kami.</p>
        </div>

        @if(session('success'))
        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">✓</div>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
        @endif

        <div class="glass p-8 md:p-12 rounded-[2.5rem] shadow-2xl border border-slate-200">
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-6 py-4 rounded-xl border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="phone" required class="w-full px-6 py-4 rounded-xl border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all" placeholder="0812xxxx">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Jenis Aduan</label>
                    <select name="type" required class="w-full px-6 py-4 rounded-xl border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all">
                        <option value="">Pilih Jenis Aduan</option>
                        <option value="Kualitas Makanan">Kualitas Makanan</option>
                        <option value="Keterlambatan Pengiriman">Keterlambatan Pengiriman</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Pelayanan Petugas">Pelayanan Petugas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Deskripsi Masalah</label>
                    <textarea name="description" required rows="5" class="w-full px-6 py-4 rounded-xl border border-slate-200 focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/10 outline-none transition-all" placeholder="Ceritakan detail kendala yang Anda alami..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Foto Pendukung (Opsional)</label>
                    <input type="file" name="photo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-slate-900 file:text-white hover:file:bg-slate-800 transition-all">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:scale-[1.02] hover:bg-black transition-all">
                        Kirim Aduan Sekarang
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-8 text-center text-xs text-slate-400 font-bold uppercase tracking-widest">Aduan Anda akan diproses dalam waktu maksimal 24 jam kerja.</p>
    </main>

</body>
</html>
