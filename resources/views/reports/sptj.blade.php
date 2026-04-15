<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            {{ __('Surat Pernyataan Tanggung Jawab') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gold/10">
                <div class="p-16 text-gray-900 font-jakarta">
                    <!-- Heading -->
                    <div class="text-center mb-12 border-b-2 border-royal-navy pb-8">
                        <h3 class="text-xs font-black text-gold-dark uppercase tracking-[0.5em] mb-4 leading-none">Kop surat Yayasan</h3>
                        <h1 class="text-3xl font-black text-royal-navy uppercase tracking-tight font-playfair mb-2">SURAT PERNYATAAN TANGGUNG JAWAB</h1>
                    </div>

                    <div class="space-y-10 leading-[2]">
                        <p class="text-base text-slate-800">Saya yang bertanda tangan di bawah ini:</p>

                        <div class="space-y-4 ml-10">
                            <div class="flex">
                                <span class="w-32 font-bold text-slate-400 uppercase text-xs tracking-widest">Nama</span>
                                <span class="font-black text-royal-navy flex-1 ml-4 border-b border-slate-200 uppercase">: {{ $data['nama'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-32 font-bold text-slate-400 uppercase text-xs tracking-widest">Jabatan</span>
                                <span class="font-bold text-slate-700 flex-1 ml-4 border-b border-slate-200 uppercase">: {{ $data['jabatan'] }}</span>
                            </div>
                        </div>

                        <div class="text-base text-slate-800 text-justify">
                            menyatakan bertanggung jawab secara formal dan material atas penerimaan dan pengeluaran dana yang dilaksanakan dengan menggunakan dana APBN TA 2026 melalui DIPA Badan Gizi Nasional TA 2026, dengan mata anggaran sebagai Bantuan Pemerintah untuk Program Makan Bergizi Gratis. Sebagaimana Surat Pernyataan Tanggung Jawab penggunaan anggaran <span class="font-black text-royal-navy underline decoration-gold">Bahan Baku/Operasional/Insentif Fasilitas</span> beserta bukti-bukti pengeluaran yang sah dengan rincian:
                        </div>

                        <!-- Data Table -->
                        <div class="bg-silk rounded-3xl p-10 border border-gold/10 shadow-inner max-w-lg mx-auto">
                            <ul class="space-y-6">
                                <li class="flex justify-between items-center group">
                                    <span class="text-sm font-bold text-slate-500 uppercase tracking-widest group-hover:text-royal-navy transition-colors">1. Jumlah Penerimaan</span>
                                    <div class="flex items-center">
                                        <span class="text-royal-navy font-bold mr-3">:</span>
                                        <span class="text-xl font-black text-royal-navy">{{ number_format($data['penerimaan']) }}</span>
                                    </div>
                                </li>
                                <li class="flex justify-between items-center group">
                                    <span class="text-sm font-bold text-slate-500 uppercase tracking-widest group-hover:text-royal-navy transition-colors">2. Jumlah Pengeluaran</span>
                                    <div class="flex items-center">
                                        <span class="text-royal-navy font-bold mr-3">:</span>
                                        <span class="text-xl font-black text-royal-navy">{{ number_format($data['pengeluaran']) }}</span>
                                    </div>
                                </li>
                                <div class="h-px bg-royal-navy/20 w-full"></div>
                                <li class="flex justify-between items-center group">
                                    <span class="text-sm font-black text-gold-dark uppercase tracking-[0.2em] group-hover:text-gold transition-colors">3. Sisa Dana</span>
                                    <div class="flex items-center">
                                        <span class="text-royal-navy font-bold mr-3">:</span>
                                        <span class="text-2xl font-black text-royal-navy underline decoration-gold decoration-4 underline-offset-8">{{ number_format($data['sisa']) }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <p class="text-base text-slate-800 text-justify">
                            Demikian surat ini saya buat untuk dapat dipergunakan sebagaimana mestinya dan untuk dapat dipertanggungjawabkan.
                        </p>

                        <!-- Signatures -->
                        <div class="pt-16 flex flex-col items-end text-center uppercase tracking-widest">
                            <div class="w-80">
                                <p class="text-xs font-bold text-slate-500 mb-1">{{ $data['lokasi'] }}, {{ $data['tanggal'] }}</p>
                                <p class="text-sm font-black text-royal-navy mb-32">{{ $data['jabatan'] }}</p>
                                
                                <p class="text-lg font-black text-royal-navy border-b-4 border-royal-navy pb-1 inline-block px-10">{{ $data['nama'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-2 font-bold tracking-[0.3em]">( Materai )</p>
                            </div>
                        </div>
                    </div>

                    <!-- Print Button -->
                    <div class="mt-20 text-center no-print">
                        <button onclick="window.print()" class="px-10 py-4 bg-royal-navy text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl hover:bg-gold transition-all transform hover:-translate-y-1 active:scale-95">
                            Cetak Surat Pertanggungjawaban
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
            .bg-silk { background: #f8fafc !important; }
            .p-16 { padding: 0 !important; }
        }
    </style>
</x-app-layout>
