<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-xs font-bold text-gold-dark uppercase tracking-[0.3em] mb-1">Pelaporan Layanan</span>
            <h2 class="text-3xl font-playfair font-black text-royal-navy italic leading-tight">
                Laporan Harian SPPG
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-[2rem] shadow-2xl shadow-gold/5 border border-gold/10 overflow-hidden">
            <div class="bg-royal-navy p-10 relative overflow-hidden">
                <!-- Background Decorations -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gold/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-gold-premium/5 rounded-full blur-2xl -ml-24 -mb-24"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-playfair font-bold text-gold-light mb-2">Upload Laporan Harian</h3>
                    <p class="text-white/60 text-sm max-w-md">Unggah dokumentasi dan laporan kegiatan harian Anda untuk memastikan semua data tercatat dengan sempurna.</p>
                </div>
            </div>

            <div class="px-10 pt-8">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="p-6 bg-emerald-50 border border-emerald-200 rounded-3xl flex items-center gap-4 animate-bounce">
                        <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm font-bold text-emerald-800 leading-tight">{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-6 bg-red-50 border border-red-200 rounded-3xl space-y-2">
                        <p class="text-xs font-black text-red-600 uppercase tracking-widest">Terdapat Kesalahan:</p>
                        <ul class="list-disc list-inside text-xs font-bold text-red-800">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <form action="{{ route('reports.daily.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Date Selection -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Tanggal Kegiatan</label>
                        <div class="relative group">
                            <input type="date" name="report_date" required 
                                class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-bold text-royal-navy transition-all duration-300 group-hover:border-gold/20">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gold-dark group-hover:text-gold transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                    </div>

                <!-- Report Type -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Jenis Laporan</label>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <label class="relative flex items-center justify-center p-5 rounded-[1.5rem] border-2 border-gold/5 bg-silk hover:border-gold-premium/30 cursor-pointer transition-all has-[:checked]:border-gold-premium has-[:checked]:bg-gold-light/20 group overflow-hidden">
                            <input type="radio" name="report_type" value="Harian Aslap" class="hidden" checked>
                            <div class="text-center">
                                <span class="block text-[11px] font-black text-royal-navy group-hover:text-gold-dark uppercase tracking-wider">Harian Aslap</span>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-center p-5 rounded-[1.5rem] border-2 border-gold/5 bg-silk hover:border-gold-premium/30 cursor-pointer transition-all has-[:checked]:border-gold-premium has-[:checked]:bg-gold-light/20 group overflow-hidden">
                            <input type="radio" name="report_type" value="Harian Gizi" class="hidden">
                            <div class="text-center">
                                <span class="block text-[11px] font-black text-royal-navy group-hover:text-gold-dark uppercase tracking-wider">Harian Gizi</span>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-center p-5 rounded-[1.5rem] border-2 border-gold/5 bg-silk hover:border-gold-premium/30 cursor-pointer transition-all has-[:checked]:border-gold-premium has-[:checked]:bg-gold-light/20 group overflow-hidden">
                            <input type="radio" name="report_type" value="Harian Keuangan" class="hidden">
                            <div class="text-center">
                                <span class="block text-[11px] font-black text-royal-navy group-hover:text-gold-dark uppercase tracking-wider">Harian Keuangan</span>
                            </div>
                        </label>
                        <label class="relative flex items-center justify-center p-5 rounded-[1.5rem] border-2 border-gold/5 bg-silk hover:border-gold-premium/30 cursor-pointer transition-all has-[:checked]:border-gold-premium has-[:checked]:bg-gold-light/20 group overflow-hidden">
                            <input type="radio" name="report_type" value="Informasi Penting" class="hidden">
                            <div class="text-center">
                                <span class="block text-[11px] font-black text-royal-navy group-hover:text-gold-dark uppercase tracking-wider">Informasi Penting</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="space-y-2" x-data="{ fileName: '' }">
                    <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Dokumentasi (Foto/PDF)</label>
                    <div class="relative">
                        <input type="file" name="attachment" id="attachment" required class="hidden" @change="fileName = $event.target.files[0].name">
                        <label for="attachment" class="flex flex-col items-center justify-center w-full min-h-[160px] border-2 border-dashed border-gold/20 bg-silk rounded-3xl hover:bg-gold-light/10 hover:border-gold-premium/40 transition-all duration-500 cursor-pointer group">
                            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-500 mb-4">
                                <svg class="w-8 h-8 text-gold-premium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002 -2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <span class="text-sm font-bold text-royal-navy group-hover:text-gold-dark transition-colors" x-text="fileName || 'Pilih Berkas Laporan'"></span>
                            <span class="text-[10px] text-royal-navy/40 mt-1 uppercase tracking-tighter">Maksimal 10MB (JPG, PNG, PDF)</span>
                        </label>
                    </div>
                </div>

                <!-- Notes -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gold-dark uppercase tracking-widest pl-1">Catatan Tambahan</label>
                    <textarea name="notes" placeholder="Berikan keterangan singkat tentang laporan ini..." rows="4"
                        class="w-full bg-silk border-2 border-gold/5 focus:border-gold-premium focus:ring-0 rounded-2xl py-4 px-5 text-sm font-medium text-royal-navy transition-all duration-300 hover:border-gold/20 placeholder:text-royal-navy/30"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-royal-navy hover:bg-gold-premium text-white hover:text-royal-navy font-playfair font-black text-xl py-6 rounded-2xl transition-all duration-500 shadow-xl shadow-royal-navy/10 flex items-center justify-center gap-3 group">
                    <span>SIMPAN LAPORAN</span>
                    <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 flex items-center justify-center gap-6 opacity-40">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-1.5 rounded-full bg-gold-dark"></div>
                <span class="text-[10px] font-black uppercase tracking-widest">Aman</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-1.5 h-1.5 rounded-full bg-gold-dark"></div>
                <span class="text-[10px] font-black uppercase tracking-widest">Terverifikasi</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-1.5 h-1.5 rounded-full bg-gold-dark"></div>
                <span class="text-[10px] font-black uppercase tracking-widest">Real-time</span>
            </div>
        </div>
    </div>
</x-app-layout>
