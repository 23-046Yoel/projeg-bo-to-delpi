<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Isi Laporan Pengolahan') }}
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
            <form action="{{ route('production.processing.store', $menu) }}" method="POST">
                @csrf
                <div class="premium-card p-8 mb-8 border-l-8 border-gold">
                    <h3 class="text-sm font-black text-royal-navy uppercase tracking-widest mb-6 border-b pb-4 flex items-center justify-between">
                        Waktu Seluruh Proses Pengolahan
                        <button type="submit" class="px-6 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all shadow-lg shadow-gold/20">Simpan Waktu Proses</button>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Mulai Seluruh Proses</label>
                            <div class="flex gap-2">
                                <input type="datetime-local" name="proc_start" id="proc_start" value="{{ ($menu->productionLog && $menu->productionLog->proc_start) ? \Carbon\Carbon::parse($menu->productionLog->proc_start)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                <button type="button" onclick="setNow('proc_start')" class="px-4 py-2 bg-royal-navy text-white text-[10px] font-black uppercase rounded-xl hover:bg-royal-navy/80 transition-all">Mulai</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Selesai Seluruh Proses</label>
                            <div class="flex gap-2">
                                <input type="datetime-local" name="proc_end" id="proc_end" value="{{ ($menu->productionLog && $menu->productionLog->proc_end) ? \Carbon\Carbon::parse($menu->productionLog->proc_end)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                <button type="button" onclick="setNow('proc_end')" class="px-4 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all">Selesai</button>
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

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Mulai</label>
                                    <div class="flex gap-2">
                                        <input type="datetime-local" name="items[{{ $dish->id }}][start_time]" id="start_{{ $dish->id }}" value="{{ isset($proc->start_time) ? \Carbon\Carbon::parse($proc->start_time)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                        <button type="button" onclick="setNow('start_{{ $dish->id }}')" class="px-3 py-2 bg-royal-navy text-white text-[10px] font-black uppercase rounded-xl hover:bg-royal-navy/80 transition-all">Mulai</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Selesai</label>
                                    <div class="flex gap-2">
                                        <input type="datetime-local" name="items[{{ $dish->id }}][end_time]" id="end_{{ $dish->id }}" value="{{ isset($proc->end_time) ? \Carbon\Carbon::parse($proc->end_time)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                        <button type="button" onclick="setNow('end_{{ $dish->id }}')" class="px-3 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all">Selesai</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Foto Suhu Mendidih</label>
                                    @if(isset($proc->boiling_temp_photo))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $proc->boiling_temp_photo) }}" class="w-20 h-20 object-cover rounded-lg border">
                                        </div>
                                    @endif
                                    <input type="file" name="items[{{ $dish->id }}][boiling_temp_photo]" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gold file:text-royal-navy hover:file:bg-gold/80 cursor-pointer">
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
