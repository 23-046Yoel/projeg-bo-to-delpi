<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            {{ __('Berita Acara Pengalihan Sisa Dana') }}
        </h2>
    </x-slot>

    <div class="py-12 no-print">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p class="text-sm font-bold text-blue-800 italic">Mode Edit Aktif: Bapak bisa langsung klik dan ketik pada teks di bawah untuk mengubah isinya.</p>
                </div>
                <button onclick="window.print()" class="px-6 py-2 bg-royal-navy text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-gold transition-all">Cetak Sekarang</button>
            </div>
        </div>
    </div>

    <div class="pb-24">
        <div class="max-w-[800px] mx-auto bg-white p-[60px] shadow-2xl border border-gray-100 print:shadow-none print:p-0 print:border-none font-serif text-[#1e293b]">
            <!-- Heading -->
            <div class="text-center mb-12">
                <p class="text-[12px] font-medium mb-4" contenteditable="true">Kop surat SPPG</p>
                <div class="border-t-4 border-double border-black w-full mb-10"></div>
                <div class="relative">
                    <h1 class="text-[18px] font-black tracking-[0.1em] border-b-2 border-black inline-block px-4 mb-12" contenteditable="true">BERITA ACARA PENGALIHAN SISA DANA</h1>
                    <div class="absolute top-[-50px] right-0">
                        <div class="w-10 h-10 border-2 border-[#1e293b] flex items-center justify-center p-1">
                            <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8 text-[15px] leading-[1.8]">
                <div class="text-justify" contenteditable="true">
                    Sehubungan dengan telah berakhirnya periode <span class="font-black underline">{{ $data['periode_berakhir'] }}</span>, sisa dana sebesar
                    <span class="font-black">Rp {{ number_format($data['sisa_dana']) }},-</span> akan dialihkan ke periode selanjutnya yang dimulai pada tanggal <span class="font-black underline">{{ $data['periode_mulai'] }}</span>.
                </div>

                <p class="text-justify" contenteditable="true">
                    Pengalihan sisa dana ini bertujuan untuk mendukung kegiatan yang direncanakan pada periode berikutnya.
                </p>

                <!-- Signatures Grid -->
                <div class="pt-16">
                    <div class="text-center text-[13px] italic mb-12" contenteditable="true">BALIMBINGAN, {{ $data['tanggal'] }}</div>
                    
                    <div class="grid grid-cols-2 gap-x-20 text-center uppercase font-bold text-[13px]">
                        <div class="space-y-24">
                            <div contenteditable="true">Pihak Pertama,<br>PENDIDIKAN ALA DELPHI</div>
                            <div class="border-b-2 border-black w-full pb-1 font-black" contenteditable="true">{{ $data['pihak_pertama'] }}</div>
                            <div class="text-[11px] normal-case" contenteditable="true">Ketua/Mewakili</div>
                        </div>
                        
                        <div class="space-y-24">
                            <div contenteditable="true">Pihak Kedua,<br>Staf Pengawas Keuangan<br>SPPG BALIMBINGAN 2</div>
                            <div class="border-b-2 border-black w-full pb-1 font-black" contenteditable="true">{{ $data['pihak_kedua'] }}</div>
                            <div class="text-[11px] normal-case" contenteditable="true">Staf Pengawas Keuangan</div>
                        </div>

                        <div class="col-span-2 mt-12 space-y-24">
                            <div contenteditable="true">Mengetahui,<br>Kepala SPPG BALIMBINGAN 2</div>
                            <div class="border-b-2 border-black w-64 mx-auto pb-1 font-black" contenteditable="true">{{ $data['mengetahui'] }}</div>
                            <div class="text-[11px] normal-case" contenteditable="true">Kepala SPPG BALIMBINGAN 2</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    <!-- Print Button -->
                    <div class="mt-24 text-center no-print">
                        <button onclick="window.print()" class="px-12 py-5 bg-royal-navy text-white rounded-3xl font-black uppercase tracking-[0.3em] shadow-[0_20px_50px_rgba(15,23,42,0.3)] hover:bg-gold transition-all transform hover:-translate-y-2 active:scale-95">
                            Cetak Berita Acara
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .shadow-2xl { shadow: none !important; }
            .p-20 { padding: 0 !important; }
        }
    </style>
</x-app-layout>
