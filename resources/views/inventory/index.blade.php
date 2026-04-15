<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Laporan Stok Gudang') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Audit Saldo Bahan Baku: {{ \Carbon\Carbon::parse($startDate)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/y') }}</p>
            </div>
            
            <form action="{{ route('inventory.index') }}" method="GET" class="flex items-center space-x-4 bg-silk p-2 rounded-2xl border border-gray-100">
                <div class="flex items-center px-4 space-x-2">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">From:</span>
                    <input name="start_date" type="date" value="{{ $startDate }}" class="bg-transparent border-none focus:ring-0 text-xs font-bold text-royal-navy p-0 w-32">
                </div>
                <div class="flex items-center px-4 space-x-2 border-l border-gray-100">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">To:</span>
                    <input name="end_date" type="date" value="{{ $endDate }}" class="bg-transparent border-none focus:ring-0 text-xs font-bold text-royal-navy p-0 w-32">
                </div>
                <button type="submit" class="bg-royal-navy text-gold text-[10px] font-black uppercase tracking-widest px-6 py-2.5 rounded-xl hover:bg-royal-navy/90 transition-all shadow-lg shadow-royal-navy/10">
                    Run Audit
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-50 overflow-hidden">
                <div class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                        @php
                            $total_masuk = collect($report)->sum('masuk');
                            $total_keluar = collect($report)->sum('keluar');
                            $items_count = count($report);
                        @endphp
                        <div class="p-8 bg-silk rounded-[2rem] relative overflow-hidden group">
                           <div class="relative z-10">
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Materials</div>
                                <div class="text-3xl font-black text-royal-navy">{{ $items_count }} Items</div>
                           </div>
                           <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                           </div>
                        </div>

                        <div class="p-8 bg-emerald-50 rounded-[2rem] relative overflow-hidden group">
                           <div class="relative z-10">
                                <div class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Total Inbound</div>
                                <div class="text-3xl font-black text-emerald-600">+{{ number_format($total_masuk, 1) }}</div>
                           </div>
                           <div class="absolute -right-4 -bottom-4 opacity-10">
                                <svg class="w-24 h-24 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M7 11l5-5 5 5M7 13l5 5 5-5"/></svg>
                           </div>
                        </div>

                        <div class="p-8 bg-rose-50 rounded-[2rem] relative overflow-hidden group">
                           <div class="relative z-10">
                                <div class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-2">Total Outbound</div>
                                <div class="text-3xl font-black text-rose-600">-{{ number_format($total_keluar, 1) }}</div>
                           </div>
                           <div class="absolute -right-4 -bottom-4 opacity-10">
                                <svg class="w-24 h-24 text-rose-600" fill="currentColor" viewBox="0 0 24 24"><path d="M7 11l5-5 5 5M7 13l5 5 5-5"/></svg>
                           </div>
                        </div>

                        <div x-data="{ open: false, type: 'in' }" class="p-8 bg-royal-navy rounded-[2rem] relative overflow-hidden group shadow-xl">
                           <div class="relative z-10">
                                <div class="text-[10px] font-black text-gold uppercase tracking-widest mb-4">Aksi Cepat</div>
                                <div class="flex gap-2">
                                    <button @click="open = true; type = 'in'" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl py-3 px-4 text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20">
                                        + Tambah
                                    </button>
                                    <button @click="open = true; type = 'out'" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white rounded-xl py-3 px-4 text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-rose-500/20">
                                        - Kurang
                                    </button>
                                </div>
                           </div>
                           
                           {{-- Adjustment Modal --}}
                           <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-royal-navy/60 backdrop-blur-sm" x-cloak>
                                <div @click.away="open = false" class="bg-white rounded-[2.5rem] p-10 w-full max-w-md shadow-2xl border border-gray-100 animate-fadeIn">
                                    <h3 class="text-xl font-black text-royal-navy uppercase tracking-tight mb-6" x-text="type === 'in' ? 'Tambah Stok Manual' : 'Kurangi Stok Manual'"></h3>
                                    
                                    <form action="{{ route('inventory.adjust') }}" method="POST" class="space-y-6">
                                        @csrf
                                        <input type="hidden" name="type" :value="type">
                                        
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Pilih Bahan Baku</label>
                                            <select name="material_id" required class="select2 w-full px-6 py-4 bg-silk border-none rounded-2xl text-sm font-bold text-royal-navy focus:ring-2 focus:ring-gold outline-none">
                                                <option value=""></option>
                                                @foreach($materials as $m)
                                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->unit }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Jumlah (Quantity)</label>
                                            <input type="number" step="0.01" name="quantity" required class="w-full px-6 py-4 bg-silk border-none rounded-2xl text-sm font-bold text-royal-navy focus:ring-2 focus:ring-gold outline-none" placeholder="0.00">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Catatan (Optional)</label>
                                            <input type="text" name="note" class="w-full px-6 py-4 bg-silk border-none rounded-2xl text-sm font-bold text-royal-navy focus:ring-2 focus:ring-gold outline-none" placeholder="Contoh: Stok rusak, bonus supplier...">
                                        </div>

                                        <div class="flex gap-4 pt-4">
                                            <button type="button" @click="open = false" class="flex-1 py-4 bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-gray-200 transition-all">Batal</button>
                                            <button type="submit" class="flex-1 py-4 bg-royal-navy text-gold text-[10px] font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-xl shadow-royal-navy/20">Proses</button>
                                        </div>
                                    </form>
                                </div>
                           </div>
                        </div>
                    </div>

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
                            @foreach($report as $item)
                                <tr class="hover:bg-silk/30 transition-colors group">
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-2.5 h-2.5 rounded-full bg-gold mr-3"></div>
                                            <span class="text-sm font-bold text-royal-navy">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-right font-bold text-gray-400 text-sm">
                                        {{ number_format($item['saldo_awal'], 2) }}
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-right font-black text-emerald-500 text-sm">
                                        +{{ number_format($item['masuk'], 2) }}
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-right font-black text-rose-500 text-sm">
                                        -{{ number_format($item['keluar'], 2) }}
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-right">
                                        <div class="inline-block px-4 py-2 rounded-xl {{ $item['saldo_akhir'] < 0 ? 'bg-rose-50 text-rose-600' : 'bg-royal-navy text-gold' }} text-lg font-black font-playfair">
                                            {{ number_format($item['saldo_akhir'], 2) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
