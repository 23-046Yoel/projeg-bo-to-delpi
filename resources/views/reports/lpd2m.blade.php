<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            {{ __('Laporan Penggunaan Dana Dua Pekanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gold/10">
                <div class="p-12 text-gray-900 font-jakarta">
                    <!-- Document Header -->
                    <div class="text-center mb-10 border-b-2 border-royal-navy pb-6">
                        <h3 class="text-xs font-black text-gold-dark uppercase tracking-[0.4em] mb-2 leading-none">Kop surat SPPG</h3>
                        <h1 class="text-2xl font-black text-royal-navy uppercase tracking-tight font-playfair mb-1">LAPORAN PENGGUNAAN DANA DUA PEKANAN</h1>
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Periode : {{ $data['period'] }}</p>
                    </div>

                    <div class="space-y-8">
                        <!-- Signatory Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm leading-relaxed">
                            <div class="flex">
                                <span class="w-24 font-bold text-slate-400 uppercase text-[10px] tracking-widest">Nama</span>
                                <span class="font-bold border-b border-slate-200 flex-1 ml-2">: {{ $data['user_name'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-24 font-bold text-slate-400 uppercase text-[10px] tracking-widest">Jabatan</span>
                                <span class="font-bold border-b border-slate-200 flex-1 ml-2">: {{ $data['jabatan'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-24 font-bold text-slate-400 uppercase text-[10px] tracking-widest">Yayasan</span>
                                <span class="font-bold border-b border-slate-200 flex-1 ml-2">: {{ $data['yayasan'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-24 font-bold text-slate-400 uppercase text-[10px] tracking-widest">SPPG</span>
                                <span class="font-bold border-b border-slate-200 flex-1 ml-2">: {{ $data['sppg_name'] }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-24 font-bold text-slate-400 uppercase text-[10px] tracking-widest">ID SPPG</span>
                                <span class="font-bold border-b border-slate-200 flex-1 ml-2">: {{ $data['sppg_id'] }}</span>
                            </div>
                        </div>

                        <p class="text-sm text-slate-600">Dengan ini menyatakan bahwa laporan penggunaan dana sebagai berikut:</p>

                        <!-- Section I: Financial Rincian -->
                        <div class="bg-silk rounded-2xl p-8 border border-gold/5 shadow-inner">
                            <h4 class="font-black text-royal-navy uppercase tracking-widest mb-6 border-l-4 border-gold pl-4 text-sm">I. RINCIAN KEUANGAN</h4>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-bold text-slate-700">Dana Pemasukan</span>
                                    <div class="flex items-center">
                                        <span class="font-black text-royal-navy text-lg">Rp {{ number_format($data['dana_masuk']) }}</span>
                                        <span class="text-[9px] text-slate-400 ml-3 italic">(termasuk saldo akhir periode lalu)</span>
                                    </div>
                                </div>

                                <div class="border-t border-slate-100 pt-4">
                                    <h5 class="text-[10px] font-black text-gold-dark uppercase tracking-widest mb-3 italic">Realisasi Anggaran</h5>
                                    <div class="space-y-3">
                                        <div class="flex justify-between text-sm pl-4">
                                            <span class="text-slate-600 font-bold">Bahan Baku</span>
                                            <span class="font-bold">{{ number_format($data['belanja_bahan']) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm pl-4">
                                            <span class="text-slate-600 font-bold">Operasional</span>
                                            <span class="font-bold">{{ number_format($data['operasional']) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm pl-4">
                                            <span class="text-slate-600 font-bold">Insentif Fasilitas</span>
                                            <span class="font-bold">{{ number_format($data['insentif']) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-4 border-t-2 border-royal-navy mt-4">
                                    <span class="font-black text-royal-navy uppercase tracking-tighter">Total Belanja</span>
                                    <span class="font-black text-xl text-royal-navy underline decoration-gold decoration-4 underline-offset-8">{{ number_format($data['belanja_bahan'] + $data['operasional'] + $data['insentif']) }}</span>
                                </div>

                                <div class="flex justify-between items-center pt-6">
                                    <span class="font-black text-gold-dark uppercase tracking-widest text-sm">Sisa Anggaran</span>
                                    <div class="h-px bg-gold-soft flex-1 mx-4"></div>
                                    <span class="font-black text-xl text-green-700 bg-green-50 px-4 py-1 rounded-lg border-2 border-green-200">{{ number_format($data['sisa_dana']) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Section II: Keterangan -->
                        <div class="space-y-4">
                            <h4 class="font-black text-royal-navy uppercase tracking-widest border-l-4 border-gold pl-4 text-sm">II. KETERANGAN</h4>
                            <p class="text-xs text-slate-500 leading-relaxed italic">Dana yang telah digunakan sesuai dengan kebutuhan kegiatan yang telah direncanakan, dengan rincian sebagai berikut:</p>
                            
                            <ul class="space-y-3 text-xs">
                                <li class="flex items-start">
                                    <span class="font-black text-royal-navy w-32 uppercase tracking-tighter">Bahan Baku</span>
                                    <span class="text-slate-600 ml-2">: Pengadaan bahan baku utama untuk pelaksanaan kegiatan</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="font-black text-royal-navy w-32 uppercase tracking-tighter">Operasional</span>
                                    <span class="text-slate-600 ml-2">: Biaya transportasi, ATK, bahan bakar, dan keperluan teknis lainnya.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="font-black text-royal-navy w-32 uppercase tracking-tighter">Insentif Fasilitas</span>
                                    <span class="text-slate-600 ml-2">: Bangunan, dan lain-lain.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="font-black text-royal-navy w-32 uppercase tracking-tighter">No. Rekening</span>
                                    <span class="text-royal-navy font-bold ml-2">: {{ $data['virtual_account'] }}</span>
                                </li>
                            </ul>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed mt-6">
                            Sisa dana sebesar Rp {{ number_format($data['sisa_dana']) }} akan dialihkan ke periode selanjutnya.<br>
                            Pengalihan sisa dana ini bertujuan untuk mendukung kegiatan yang telah direncanakan.
                        </p>

                        <!-- Signatures -->
                        <div class="pt-12 grid grid-cols-1 md:grid-cols-2 gap-12 text-center text-xs font-bold uppercase tracking-widest">
                            <div class="space-y-20">
                                <div>Pihak Pertama,<br>PENDIDIKAN ALA DELPHI</div>
                                <div class="border-b-2 border-slate-300 w-48 mx-auto pb-1 text-royal-navy font-black">{{ $data['pimpinan'] }}</div>
                                <div class="text-[10px] text-slate-400">Ketua/Mewakili</div>
                            </div>
                            <div class="space-y-20">
                                <div>BALIMBINGAN, 18 April 2026<br>Pihak Kedua,<br>Staf Pengawas Keuangan SPPG BALIMBINGAN 2</div>
                                <div class="border-b-2 border-slate-300 w-48 mx-auto pb-1 text-royal-navy font-black">{{ $data['bendahara'] }}</div>
                                <div class="text-[10px] text-slate-400">AGITA SEBAYANG</div>
                            </div>
                            
                            <div class="md:col-span-2 mt-12 space-y-20">
                                <div>Mengetahui,<br>Kepala SPPG BALIMBINGAN 2</div>
                                <div class="border-b-2 border-slate-300 w-48 mx-auto pb-1 text-royal-navy font-black">{{ $data['ka_sppg'] }}</div>
                                <div class="text-[10px] text-slate-400">ABDI SEPTIAN</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Print Button -->
                    <div class="mt-16 text-center no-print">
                        <button onclick="window.print()" class="px-8 py-3 bg-royal-navy text-white rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-gold transition-all transform hover:-translate-y-1 active:scale-95">
                            Cetak Laporan
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
        }
    </style>
</x-app-layout>
