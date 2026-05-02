<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Isi Laporan Persiapan') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">
                    {{ $menu->sppg->name }} | {{ \Carbon\Carbon::parse($menu->date)->translatedFormat('d F Y') }}
                </p>
            </div>
            <a href="{{ route('production.preparation.index') }}" class="px-5 py-2 bg-silk border border-gray-200 rounded-xl text-[10px] font-black text-royal-navy uppercase tracking-widest hover:bg-gray-50 transition-all">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('production.preparation.store', $menu) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Overall Time Section -->
                <div class="premium-card p-8 mb-8">
                    <h3 class="text-sm font-black text-royal-navy uppercase tracking-widest mb-6 border-b pb-4">Waktu Seluruh Proses Persiapan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Mulai Seluruh Proses</label>
                            <input type="datetime-local" name="prep_start" value="{{ $menu->productionLog->prep_start ? \Carbon\Carbon::parse($menu->productionLog->prep_start)->format('Y-m-d\TH:i') : '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Selesai Seluruh Proses</label>
                            <input type="datetime-local" name="prep_end" value="{{ $menu->productionLog->prep_end ? \Carbon\Carbon::parse($menu->productionLog->prep_end)->format('Y-m-d\TH:i') : '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Per Material Section -->
                <div class="space-y-6">
                    @foreach($materialsNeeded as $matId => $item)
                        @php
                            $prep = $menu->preparations->where('material_id', $matId)->first();
                        @endphp
                        <div class="premium-card p-8">
                            <div class="flex items-center justify-between mb-6 border-b pb-4">
                                <h3 class="text-sm font-black text-gold-dark uppercase tracking-widest">{{ $item['material']->name }}</h3>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estimasi Kebutuhan: {{ number_format($item['estimated_qty'], 2) }} {{ $item['material']->unit }}</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Diterima dari Gudang</label>
                                    <input type="number" step="0.01" name="items[{{ $matId }}][qty_received]" value="{{ $prep->qty_received ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Hasil Persiapan (Kirim ke Pengolahan)</label>
                                    <input type="number" step="0.01" name="items[{{ $matId }}][qty_prepared]" value="{{ $prep->qty_prepared ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Dikembalikan ke Gudang</label>
                                    <input type="number" step="0.01" name="items[{{ $matId }}][qty_returned]" value="{{ $prep->qty_returned ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Sampah/Limbah</label>
                                    <input type="number" step="0.01" name="items[{{ $matId }}][qty_waste]" value="{{ $prep->qty_waste ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Mulai</label>
                                    <input type="datetime-local" name="items[{{ $matId }}][start_time]" value="{{ isset($prep->start_time) ? \Carbon\Carbon::parse($prep->start_time)->format('Y-m-d\TH:i') : '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Selesai</label>
                                    <input type="datetime-local" name="items[{{ $matId }}][end_time]" value="{{ isset($prep->end_time) ? \Carbon\Carbon::parse($prep->end_time)->format('Y-m-d\TH:i') : '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Foto Hasil Persiapan</label>
                                    @if(isset($prep->photo))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $prep->photo) }}" class="w-20 h-20 object-cover rounded-lg border">
                                        </div>
                                    @endif
                                    <input type="file" name="items[{{ $matId }}][photo]" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gold file:text-royal-navy hover:file:bg-gold/80 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-gold text-royal-navy font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all transform hover:-translate-y-1">
                        Simpan Laporan Persiapan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
