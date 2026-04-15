<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            {{ __('Berita Acara Pengalihan Sisa Dana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gold/10">
                <div class="p-20 text-gray-900 font-jakarta leading-loose">
                    <!-- Heading -->
                    <div class="text-center mb-16 border-b-2 border-royal-navy pb-10">
                        <h3 class="text-xs font-black text-gold-dark uppercase tracking-[0.6em] mb-4 leading-none">Kop surat SPPG</h3>
                        <h1 class="text-3xl font-black text-royal-navy uppercase tracking-tighter font-playfair mb-2">BERITA ACARA PENGALIHAN SISA DANA</h1>
                    </div>

                    <div class="space-y-12">
                        <div class="text-lg text-slate-800 text-justify">
                            Sehubungan dengan telah berakhirnya periode <span class="font-black text-royal-navy underline decoration-gold">{{ $data['periode_berakhir'] }}</span>, sisa dana sebesar
                            <span class="font-black text-royal-navy bg-gold/10 px-3 py-1 rounded-lg">Rp {{ number_format($data['sisa_dana']) }},-</span> akan dialihkan ke periode selanjutnya yang dimulai pada tanggal <span class="font-black text-royal-navy underline decoration-gold">{{ $data['periode_mulai'] }}</span>.
                        </div>

                        <div class="text-lg text-slate-800 text-justify italic font-playfair border-l-4 border-gold pl-6 py-2">
                            "Pengalihan sisa dana ini bertujuan untuk mendukung kegiatan yang direncanakan pada periode berikutnya."
                        </div>

                        <!-- Signatures Grid -->
                        <div class="pt-20">
                            <div class="text-center text-xs font-bold text-slate-400 uppercase tracking-[0.5em] mb-12">BALIMBINGAN, {{ $data['tanggal'] }}</div>
                            
                            <div class="grid grid-cols-2 gap-20 text-center uppercase tracking-widest text-xs font-bold">
                                <div class="space-y-32">
                                    <div>Pihak Pertama,<br>PENDIDIKAN ALA DELPHI</div>
                                    <div class="border-b-2 border-slate-300 w-full pb-2 text-royal-navy font-black text-sm">{{ $data['pihak_pertama'] }}</div>
                                    <div class="text-[10px] text-slate-400 tracking-[0.3em]">Ketua/Mewakili</div>
                                </div>
                                
                                <div class="space-y-32">
                                    <div>Pihak Kedua,<br>Staf Pengawas Keuangan SPPG BALIMBINGAN 2</div>
                                    <div class="border-b-2 border-slate-300 w-full pb-2 text-royal-navy font-black text-sm">{{ $data['pihak_kedua'] }}</div>
                                    <div class="text-[10px] text-slate-400 tracking-[0.3em]">Pengawas Keuangan</div>
                                </div>

                                <div class="col-span-2 mt-12 space-y-32">
                                    <div>Mengetahui,<br>Kepala SPPG BALIMBINGAN 2</div>
                                    <div class="border-b-2 border-slate-300 w-64 mx-auto pb-2 text-royal-navy font-black text-sm">{{ $data['mengetahui'] }}</div>
                                    <div class="text-[10px] text-slate-400 tracking-[0.3em]">Pimpinan SPPG</div>
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
