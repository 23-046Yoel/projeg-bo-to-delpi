<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Isi Laporan Pemorsian') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">
                    {{ $menu->sppg->name }} | {{ \Carbon\Carbon::parse($menu->date)->translatedFormat('d F Y') }}
                </p>
            </div>
            <a href="{{ route('production.portioning.index') }}" class="px-5 py-2 bg-silk border border-gray-200 rounded-xl text-[10px] font-black text-royal-navy uppercase tracking-widest hover:bg-gray-50 transition-all">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('production.portioning.store', $menu) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Overall Section -->
                <div class="premium-card p-8 mb-8">
                    <h3 class="text-sm font-black text-royal-navy uppercase tracking-widest mb-6 border-b pb-4">Waktu & Foto Keseluruhan Pemorsian</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Mulai Seluruhnya</label>
                            <div class="flex gap-2">
                                <input type="datetime-local" name="port_start" id="port_start" value="{{ ($menu->productionLog && $menu->productionLog->port_start) ? \Carbon\Carbon::parse($menu->productionLog->port_start)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                <button type="button" onclick="setNow('port_start')" class="px-4 py-2 bg-royal-navy text-white text-[10px] font-black uppercase rounded-xl hover:bg-royal-navy/80 transition-all">Mulai</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Selesai Seluruhnya</label>
                            <div class="flex gap-2">
                                <input type="datetime-local" name="port_end" id="port_end" value="{{ ($menu->productionLog && $menu->productionLog->port_end) ? \Carbon\Carbon::parse($menu->productionLog->port_end)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                <button type="button" onclick="setNow('port_end')" class="px-4 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all">Selesai</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Foto Kumpulan Ompreng</label>
                            @if($menu->productionLog && isset($menu->productionLog->port_all_photo))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $menu->productionLog->port_all_photo) }}" class="w-20 h-20 object-cover rounded-lg border">
                                </div>
                            @endif
                            <input type="file" name="port_all_photo" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gold file:text-royal-navy hover:file:bg-gold/80 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Per Beneficiary Group Section -->
                <div class="space-y-6">
                    @foreach($menu->sppg->beneficiaryGroups as $group)
                        @php
                            $port = $menu->portionings->where('beneficiary_group_id', $group->id)->first();
                        @endphp
                        <div class="premium-card p-8">
                            <div class="flex items-center justify-between mb-6 border-b pb-4">
                                <h3 class="text-sm font-black text-gold-dark uppercase tracking-widest">{{ $group->name }}</h3>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Target: {{ $group->total_beneficiaries }} PM</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Masakan Diterima (Kg)</label>
                                    <input type="number" step="0.01" name="items[{{ $group->id }}][qty_received]" value="{{ $port->qty_received ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Mulai</label>
                                    <div class="flex gap-2">
                                        <input type="datetime-local" name="items[{{ $group->id }}][start_time]" id="start_{{ $group->id }}" value="{{ isset($port->start_time) ? \Carbon\Carbon::parse($port->start_time)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                        <button type="button" onclick="setNow('start_{{ $group->id }}')" class="px-3 py-2 bg-royal-navy text-white text-[10px] font-black uppercase rounded-xl hover:bg-royal-navy/80 transition-all">Mulai</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jam Selesai</label>
                                    <div class="flex gap-2">
                                        <input type="datetime-local" name="items[{{ $group->id }}][end_time]" id="end_{{ $group->id }}" value="{{ isset($port->end_time) ? \Carbon\Carbon::parse($port->end_time)->format('Y-m-d\TH:i') : '' }}" class="flex-1 px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                        <button type="button" onclick="setNow('end_{{ $group->id }}')" class="px-3 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all">Selesai</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Suhu Masakan (°C)</label>
                                    <input type="number" step="0.1" name="items[{{ $group->id }}][initial_temp]" value="{{ $port->initial_temp ?? '' }}" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Uji Organoleptic</label>
                                    <textarea name="items[{{ $group->id }}][organoleptic_test]" rows="3" class="w-full px-5 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy focus:border-gold outline-none transition-all" placeholder="Rasa, Aroma, Tekstur, dll...">{{ $port->organoleptic_test ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Foto Menu di Ompreng</label>
                                    @if(isset($port->ompreng_photo))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $port->ompreng_photo) }}" class="w-20 h-20 object-cover rounded-lg border">
                                        </div>
                                    @endif
                                    <input type="file" name="items[{{ $group->id }}][ompreng_photo]" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gold file:text-royal-navy hover:file:bg-gold/80 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-gold text-royal-navy font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all transform hover:-translate-y-1">
                        Simpan Laporan Pemorsian
                    </button>
                </div>
            </form>
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
