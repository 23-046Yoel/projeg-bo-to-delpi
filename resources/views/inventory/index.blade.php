<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Laporan Stok Gudang') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Audit Saldo Bahan Baku: {{ \Carbon\Carbon::parse($startDate)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/y') }}</p>
            </div>
            
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-wrap items-center gap-3 bg-silk p-2 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-center px-4 space-x-2 border-r border-gray-100">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Dapur:</span>
                        <select name="sppg_id" class="bg-transparent border-none focus:ring-0 text-xs font-bold text-royal-navy p-0 w-32" onchange="this.form.submit()">
                            <option value="">Semua Dapur</option>
                            @foreach($sppgs as $s)
                                <option value="{{ $s->id }}" {{ $sppgId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center px-4 space-x-2 border-r border-gray-100">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Dari:</span>
                        <input name="start_date" type="date" value="{{ $startDate }}" class="bg-transparent border-none focus:ring-0 text-xs font-bold text-royal-navy p-0 w-28">
                    </div>
                    <div class="flex items-center px-4 space-x-2">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ke:</span>
                        <input name="end_date" type="date" value="{{ $endDate }}" class="bg-transparent border-none focus:ring-0 text-xs font-bold text-royal-navy p-0 w-28">
                    </div>
                    <button type="submit" class="bg-royal-navy text-gold text-[10px] font-black uppercase tracking-widest px-6 py-2.5 rounded-xl hover:bg-royal-navy/90 transition-all">
                        Filter
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12" x-data="{ openAdjustment: false, type: 'in' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] lg:rounded-[3rem] shadow-2xl border border-gray-50 overflow-hidden">
                <div class="p-6 lg:p-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8 mb-8 lg:mb-12">
                        @php
                            $total_masuk = collect($report)->sum('masuk');
                            $total_keluar = collect($report)->sum('keluar');
                            $items_count = count($report);
                        @endphp
                        <div class="p-6 lg:p-8 bg-silk rounded-3xl lg:rounded-[2rem] relative overflow-hidden group">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 lg:mb-2">Total Materials</div>
                                <div class="text-2xl lg:text-3xl font-black text-royal-navy">{{ $items_count }} Items</div>
                        </div>

                        <div class="p-6 lg:p-8 bg-emerald-50 rounded-3xl lg:rounded-[2rem] relative overflow-hidden group text-emerald-600">
                                <div class="text-[10px] font-black uppercase tracking-widest mb-1 lg:mb-2 opacity-60">Total Inbound</div>
                                <div class="text-2xl lg:text-3xl font-black">+{{ number_format($total_masuk, 1) }}</div>
                        </div>

                        <div class="p-6 lg:p-8 bg-rose-50 rounded-3xl lg:rounded-[2rem] relative overflow-hidden group text-rose-600">
                                <div class="text-[10px] font-black uppercase tracking-widest mb-1 lg:mb-2 opacity-60">Total Outbound</div>
                                <div class="text-2xl lg:text-3xl font-black">-{{ number_format($total_keluar, 1) }}</div>
                        </div>

                        <div class="p-6 lg:p-8 bg-royal-navy rounded-3xl lg:rounded-[2rem] relative overflow-hidden group shadow-xl">
                            <div class="flex gap-2">
                                <button @click="openAdjustment = true; type = 'in'; $nextTick(() => { $('#select2-adj-input').select2({ placeholder: 'Cari bahan...' }); })" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl py-3 px-2 text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                                    + Tambah
                                </button>
                                <button @click="openAdjustment = true; type = 'out'; $nextTick(() => { $('#select2-adj-input').select2({ placeholder: 'Cari bahan...' }); })" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white rounded-xl py-3 px-2 text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                                    - Kurang
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- MOBILE FRIENDLY ADJUSTMENT FORM --}}
                    <div x-show="openAdjustment" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 -translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-8"
                         class="mb-8 lg:mb-12" x-cloak>
                        
                        <div class="bg-silk/50 border-2 border-dashed border-gold/20 rounded-3xl lg:rounded-[3rem] p-6 lg:p-12 relative overflow-hidden">
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-8 lg:mb-10">
                                    <div class="flex items-center space-x-4 lg:space-x-6">
                                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-2xl lg:rounded-[2rem] flex items-center justify-center shadow-xl" :class="type === 'in' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'">
                                            <svg x-show="type === 'in'" class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                            <svg x-show="type === 'out'" class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl lg:text-3xl font-black text-royal-navy uppercase tracking-tighter" x-text="type === 'in' ? 'Penambahan Stok' : 'Pengurangan Stok'"></h3>
                                            <p class="text-[9px] lg:text-[11px] font-bold text-gray-400 uppercase tracking-[0.3em] mt-1 lg:mt-2">Lengkapi data audit bahan baku</p>
                                        </div>
                                    </div>
                                    <button @click="openAdjustment = false" class="text-rose-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                <form action="{{ route('inventory.adjust') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
                                    @csrf
                                    <input type="hidden" name="type" :value="type">
                                    
                                    <div class="lg:col-span-2">
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-2">1. Pilih Dapur & Bahan Baku</label>
                                        <div class="grid grid-cols-1 gap-4">
                                            <select name="sppg_id" required class="w-full bg-white border-none rounded-2xl py-4 px-6 text-sm font-bold text-royal-navy shadow-sm focus:ring-2 focus:ring-gold transition-all">
                                                <option value="">-- Pilih Dapur --</option>
                                                @foreach($sppgs as $s)
                                                    <option value="{{ $s->id }}" {{ (auth()->user()->sppg_id == $s->id || $sppgId == $s->id) ? 'selected' : '' }}>{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="relative">
                                                <select name="material_id" required id="select2-adj-input" class="w-full select2">
                                                    <option value=""></option>
                                                    @foreach($materials as $m)
                                                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->unit }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-2">2. Jumlah (Kuantitas)</label>
                                        <div class="relative group">
                                            <input type="number" step="0.01" name="quantity" required class="w-full px-6 py-4 bg-white border-none rounded-2xl text-lg font-black text-royal-navy focus:ring-2 focus:ring-gold transition-all shadow-sm" placeholder="0.00" />
                                            <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-[10px] font-black text-gold-dark uppercase tracking-widest opacity-40">Unit</div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-2">3. Foto Kamera</label>
                                        <div class="relative group">
                                            <input type="file" name="photo" accept="image/*" capture="environment" class="hidden" id="photo_input" onchange="document.getElementById('photo_name').innerText = this.files[0].name">
                                            <button type="button" onclick="document.getElementById('photo_input').click()" class="w-full px-6 py-4 bg-white border-dashed border-2 border-gold/30 rounded-2xl text-xs font-bold text-gray-500 hover:border-gold transition-all flex items-center justify-center space-x-2">
                                                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                <span id="photo_name">Ambil Foto / Upload</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-3">
                                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-2">4. Catatan / Alasan (Opsional)</label>
                                        <input type="text" name="note" class="w-full px-6 py-4 bg-white border-none rounded-2xl text-sm font-bold text-royal-navy focus:ring-2 focus:ring-gold transition-all shadow-sm" placeholder="Contoh: Stok rusak, bonus supplier, opname..." />
                                    </div>

                                    <div class="flex items-end">
                                        <button type="submit" class="w-full py-4 lg:py-5 bg-royal-navy text-gold text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-royal-navy/90 transition-all shadow-xl">
                                            Proses Audit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                        <h3 class="text-[11px] font-black text-royal-navy uppercase tracking-[0.3em] flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Daftar Saldo Bahan Baku
                        </h3>
                        
                        <form action="{{ route('inventory.index') }}" method="GET" class="relative w-full md:w-80 group">
                            <input type="hidden" name="start_date" value="{{ $startDate }}">
                            <input type="hidden" name="end_date" value="{{ $endDate }}">
                            <input type="hidden" name="sppg_id" value="{{ $sppgId }}">
                            <input type="text" name="search" value="{{ $search }}" class="w-full pl-12 pr-4 py-3 bg-silk border-none rounded-xl text-xs font-bold text-royal-navy placeholder-gray-400 focus:ring-2 focus:ring-gold shadow-inner" placeholder="Cari bahan (ketik & Enter)...">
                        </form>
                    </div>

                    <div class="overflow-x-auto -mx-6 lg:mx-0">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-50">
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Material Name</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Initial Balance</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total In</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total Out</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Current Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($report as $item)
                                    <tr class="hover:bg-silk/30 transition-colors group">
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-2.5 h-2.5 rounded-full bg-gold mr-3"></div>
                                                <span class="text-sm font-bold text-royal-navy">{{ $item['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right font-bold text-gray-400 text-sm">
                                            {{ number_format($item['saldo_awal'], 2) }} <span class="text-[10px] uppercase font-black ml-1 text-slate-300">{{ $item['unit'] }}</span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right font-black text-emerald-500 text-sm">
                                            +{{ number_format($item['masuk'], 2) }} <span class="text-[10px] uppercase font-black ml-1 text-emerald-300">{{ $item['unit'] }}</span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right font-black text-rose-500 text-sm">
                                            -{{ number_format($item['keluar'], 2) }} <span class="text-[10px] uppercase font-black ml-1 text-rose-300">{{ $item['unit'] }}</span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right">
                                            <div class="inline-block px-4 py-2 rounded-xl {{ $item['saldo_akhir'] < 0 ? 'bg-rose-50 text-rose-600' : 'bg-royal-navy text-gold' }} text-lg font-black font-playfair">
                                                {{ number_format($item['saldo_akhir'], 2) }} <span class="text-[10px] uppercase font-black ml-1 opacity-60">{{ $item['unit'] }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">Data tidak ditemukan untuk dapur ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-16 mb-8 border-t border-gray-100 pt-12">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h3 class="text-[11px] font-black text-royal-navy uppercase tracking-[0.3em] flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Riwayat Audit Bahan Baku (Terkini)
                                </h3>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Daftar penyesuaian stok terbaru dengan bukti foto</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto -mx-6 lg:mx-0">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-silk/50">
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Waktu & Dapur</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Bahan Baku</th>
                                        <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tipe</th>
                                        <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kuantitas</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Catatan</th>
                                        <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Foto Bukti</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($recentLogs as $log)
                                        <tr class="hover:bg-silk/20 transition-colors">
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-[11px] font-black text-royal-navy">{{ $log->created_at->format('d/m/y H:i') }}</div>
                                                <div class="text-[9px] font-bold text-gold uppercase tracking-widest">{{ $log->sppg->name ?? 'Global' }}</div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-sm font-bold text-royal-navy">
                                                {{ $log->material->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                                @if($log->type === 'in')
                                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-[9px] font-black uppercase rounded-full">Masuk</span>
                                                @else
                                                    <span class="px-3 py-1 bg-rose-100 text-rose-600 text-[9px] font-black uppercase rounded-full">Keluar</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-black text-royal-navy">
                                                {{ number_format($log->quantity, 2) }} <span class="text-[9px] text-gray-400 uppercase ml-1">{{ $log->material->unit ?? '' }}</span>
                                            </td>
                                            <td class="px-6 py-5 text-xs text-gray-500 max-w-xs truncate">
                                                {{ $log->notes ?? '-' }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                                @if($log->photo_path)
                                                    <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-royal-navy/5 text-royal-navy hover:text-gold transition-colors rounded-lg group">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    </a>
                                                @else
                                                    <span class="text-[9px] font-bold text-gray-300 uppercase italic">No Photo</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-[10px] font-black uppercase tracking-widest">Belum ada riwayat audit baru</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
