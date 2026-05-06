<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Isi Laporan Pengolahan') }} (SUDAH UPDATE)
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">
                    {{ $menu->sppg->name }} | {{ \Carbon\Carbon::parse($menu->date)->translatedFormat('d F Y') }}
                </p>
            </div>
            <a href="{{ route('production.processing.index') }}" class="px-5 py-2 bg-silk border border-gray-200 rounded-xl text-[10px] font-black text-royal-navy uppercase tracking-widest hover:bg-gray-50 transition-all">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overall Time Section -->
            <form action="{{ route('production.processing.store', $menu) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="premium-card p-8 mb-8 border-l-8 border-gold">
                    <h3 class="text-sm font-black text-royal-navy uppercase tracking-widest mb-6 border-b pb-4 flex items-center justify-between">
                        Waktu Seluruh Proses Pengolahan
                        <button type="submit" class="px-6 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all shadow-lg shadow-gold/20">Simpan Waktu Proses</button>
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Seluruh Waktu Proses Pengolahan
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase ml-1">Jam Mulai Seluruhnya</p>
                                    <div class="flex gap-2">
                                        <input type="datetime-local" name="proc_start" id="proc_start" value="{{ ($menu->productionLog && $menu->productionLog->proc_start) ? \Carbon\Carbon::parse($menu->productionLog->proc_start)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all shadow-inner">
                                        <button type="button" onclick="setNow('proc_start')" class="px-4 py-2 bg-royal-navy text-white text-[10px] font-black uppercase rounded-xl hover:bg-royal-navy/80 transition-all active:scale-95">Mulai</button>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase ml-1">Jam Selesai Seluruhnya</p>
                                    <div class="flex gap-2">
                                        <input type="datetime-local" name="proc_end" id="proc_end" value="{{ ($menu->productionLog && $menu->productionLog->proc_end) ? \Carbon\Carbon::parse($menu->productionLog->proc_end)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all shadow-inner">
                                        <button type="button" onclick="setNow('proc_end')" class="px-4 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all active:scale-95">Selesai</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gold/10 p-6 rounded-3xl border-2 border-gold/20 space-y-6">
                            <h4 class="text-[10px] font-black text-gold-dark uppercase tracking-[0.2em] flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Rekap Quality Control (Rata-rata)
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <p class="text-[9px] font-bold text-gold-dark/60 uppercase ml-1">Suhu Rata-rata (°C)</p>
                                    <div class="relative group">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gold group-focus-within:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        </div>
                                        <input type="number" step="0.1" name="proc_temp" value="{{ $menu->productionLog->proc_temp ?? '' }}" class="w-full pl-12 pr-5 py-4 bg-white border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:border-gold outline-none transition-all shadow-sm" placeholder="85.0">
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <p class="text-[9px] font-bold text-gold-dark/60 uppercase ml-1">Foto Seluruh Proses</p>
                                    <div class="flex items-center gap-4">
                                        @if($menu->productionLog && isset($menu->productionLog->proc_all_photo))
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $menu->productionLog->proc_all_photo) }}" class="w-16 h-16 object-cover rounded-xl border-2 border-white shadow-lg group-hover:scale-110 transition-transform cursor-zoom-in">
                                                <div class="absolute inset-0 bg-black/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" name="proc_all_photo" class="w-full text-[10px] text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-gold file:text-royal-navy hover:file:bg-gold-dark hover:file:text-white transition-all cursor-pointer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="items" value="[]">
                </div>
            </form>

            <!-- Per Menu Item Section -->
            <div class="space-y-8">
                @foreach($menu->dishes as $dish)
                    @php
                        $proc = $menu->processings->where('dish_id', $dish->id)->first();
                    @endphp
                    <form action="{{ route('production.processing.store', $menu) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="premium-card p-8 border-l-8 border-royal-navy hover:shadow-2xl transition-shadow duration-500">
                            <div class="flex items-center justify-between mb-8 border-b pb-6">
                                <div>
                                    <h3 class="text-lg font-black text-royal-navy uppercase tracking-widest">{{ $dish->name }}</h3>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Porsi: {{ ($dish->pivot->porsi_besar + $dish->pivot->porsi_kecil) ?: $dish->pivot->portions }}</p>
                                </div>
                                <button type="submit" class="px-10 py-4 bg-royal-navy text-gold text-xs font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-royal-navy/90 transition-all transform hover:-translate-y-1 shadow-xl shadow-royal-navy/20">
                                    Simpan Masakan: {{ $dish->name }}
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Diterima dari Persiapan (Kg)</label>
                                    <input type="number" step="0.01" name="items[{{ $dish->id }}][qty_received]" value="{{ $proc->qty_received ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jumlah Batch</label>
                                    <input type="number" name="items[{{ $dish->id }}][batch_count]" value="{{ $proc->batch_count ?? 1 }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Berat per Batch (Kg)</label>
                                    <input type="number" step="0.01" name="items[{{ $dish->id }}][weight_per_batch]" value="{{ $proc->weight_per_batch ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Masakan Dihasilkan (Kg)</label>
                                    <input type="number" step="0.01" name="items[{{ $dish->id }}][qty_produced]" value="{{ $proc->qty_produced ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                                <!-- Group 1: Waktu Pemasakan -->
                                <div class="space-y-6">
                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Waktu Pemasakan
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <p class="text-[9px] font-bold text-gray-400 uppercase ml-1">Jam Mulai</p>
                                            <div class="flex gap-2">
                                                <input type="datetime-local" name="items[{{ $dish->id }}][start_time]" id="start_{{ $dish->id }}" value="{{ isset($proc->start_time) ? \Carbon\Carbon::parse($proc->start_time)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all shadow-inner">
                                                <button type="button" onclick="setNow('start_{{ $dish->id }}')" class="px-3 py-2 bg-royal-navy text-white text-[10px] font-black uppercase rounded-xl hover:bg-royal-navy/80 transition-all active:scale-95">Mulai</button>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-[9px] font-bold text-gray-400 uppercase ml-1">Jam Selesai</p>
                                            <div class="flex gap-2">
                                                <input type="datetime-local" name="items[{{ $dish->id }}][end_time]" id="end_{{ $dish->id }}" value="{{ isset($proc->end_time) ? \Carbon\Carbon::parse($proc->end_time)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all shadow-inner">
                                                <button type="button" onclick="setNow('end_{{ $dish->id }}')" class="px-3 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all active:scale-95">Selesai</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Group 2: Quality Control (Suhu & Foto) -->
                                <div class="bg-gold/5 p-6 rounded-3xl border border-gold/10 space-y-6">
                                    <h4 class="text-[10px] font-black text-gold-dark uppercase tracking-[0.2em] flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Quality Control (Suhu & Foto)
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                        <div class="space-y-3">
                                            <p class="text-[9px] font-bold text-gold-dark/60 uppercase ml-1">Suhu Mendidih (°C)</p>
                                            <div class="relative group">
                                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gold group-focus-within:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                </div>
                                                <input type="number" step="0.1" name="items[{{ $dish->id }}][boiling_temp]" value="{{ $proc->boiling_temp ?? '' }}" class="w-full pl-12 pr-5 py-4 bg-white border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:border-gold outline-none transition-all shadow-sm" placeholder="100.0">
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <p class="text-[9px] font-bold text-gold-dark/60 uppercase ml-1">Bukti Foto Suhu</p>
                                            <div class="flex items-center gap-4">
                                                @if(isset($proc->boiling_temp_photo))
                                                    <div class="relative group">
                                                        <img src="{{ asset('storage/' . $proc->boiling_temp_photo) }}" class="w-16 h-16 object-cover rounded-xl border-2 border-white shadow-lg group-hover:scale-110 transition-transform cursor-zoom-in">
                                                        <div class="absolute inset-0 bg-black/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                                    </div>
                                                @endif
                                                <div class="flex-1">
                                                    <input type="file" name="items[{{ $dish->id }}][boiling_temp_photo]" class="w-full text-[10px] text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-gold file:text-royal-navy hover:file:bg-gold-dark hover:file:text-white transition-all cursor-pointer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function setNow(inputId) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formatted = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById(inputId).value = formatted;
        }
    </script>
</x-app-layout>
