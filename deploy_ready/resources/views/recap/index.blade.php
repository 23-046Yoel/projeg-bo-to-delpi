<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Executive Recap') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">{{ $date }}</p>
            </div>
            
            <form action="{{ route('recap.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 bg-silk p-3 sm:p-2 rounded-2xl border border-gray-100 w-full sm:w-auto mt-4 sm:mt-0">
                <div class="flex items-center justify-between sm:justify-start space-x-2 sm:ml-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase">From:</span>
                    <input name="start_date" type="date" value="{{ $startDate }}" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-royal-navy p-0">
                </div>
                <div class="flex items-center justify-between sm:justify-start space-x-2">
                    <span class="text-[10px] font-black text-gray-400 uppercase">To:</span>
                    <input name="end_date" type="date" value="{{ $endDate }}" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-royal-navy p-0">
                </div>
                <button type="submit" class="bg-royal-navy text-white text-[10px] font-black uppercase tracking-widest px-6 py-2.5 rounded-xl hover:bg-royal-blue transition-colors w-full sm:w-auto">
                    Filter
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Daily Menu Schedule Card -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-50 p-8 relative overflow-hidden lg:col-span-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gold/5 -mr-16 -mt-16 rounded-full"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gold/20 rounded-xl flex items-center justify-center text-gold mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="text-sm font-black text-royal-navy uppercase tracking-widest">Jadwal Menu ({{ $menus->count() }} Hari)</h3>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($menus as $m)
                                <div class="bg-silk rounded-2xl p-4 border border-gray-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[10px] font-black text-gold uppercase tracking-widest">{{ \Carbon\Carbon::parse($m->date)->format('d M') }}</span>
                                        <span class="text-[10px] font-bold text-gray-400">{{ \Carbon\Carbon::parse($m->date)->isoFormat('dddd') }}</span>
                                    </div>
                                    <p class="text-royal-navy font-bold text-xs italic line-clamp-2">"{{ $m->content }}"</p>
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($m->dishes as $dish)
                                            <span class="px-2 py-0.5 bg-white rounded text-[9px] font-bold text-gray-500 border border-gray-50">{{ $dish->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 bg-silk rounded-2xl p-8 flex items-center justify-center">
                                    <p class="text-gray-300 text-xs font-bold italic text-center">Belum ada jadwal menu untuk periode ini lae...</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Financial Stats -->
                <div class="bg-royal-navy rounded-[2rem] shadow-xl p-8 text-white relative overflow-hidden">
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/5 -mr-16 -mb-16 rounded-full"></div>
                    <h3 class="text-[10px] font-black text-gold uppercase tracking-[0.2em] mb-6">Arus Kas (Approved)</h3>
                    <div class="mb-8">
                        <span class="text-3xl font-black font-playfair tracking-tight">Rp {{ number_format($payments_total) }}</span>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-2">{{ $payments_count }} Transaksi Cair</div>
                    </div>
                    <a href="{{ route('payments.index') }}" class="inline-flex items-center text-[10px] font-black text-gold uppercase tracking-widest hover:translate-x-2 transition-transform">
                        Detail Pembayaran
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Logistic Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 flex items-center justify-between">
                    <div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Porsi</h4>
                        <p class="text-xl font-black text-royal-navy">{{ number_format($dist_count) }} Unit</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 flex items-center justify-between">
                    <div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Log Masuk</h4>
                        <p class="text-xl font-black text-emerald-500">+{{ $logs_in }}</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 flex items-center justify-between">
                    <div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Log Keluar</h4>
                        <p class="text-xl font-black text-rose-500">-{{ $logs_out }}</p>
                    </div>
                    <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5-5v12"/></svg>
                    </div>
                </div>
                <div class="bg-royal-navy rounded-3xl p-6 shadow-xl flex items-center justify-between">
                    <div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Action</h4>
                        <a href="{{ route('material_logs.index') }}" class="text-[10px] font-black text-gold uppercase tracking-widest">View History</a>
                    </div>
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Aggregate Material Requirements -->
                <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-lg font-black text-royal-navy font-playfair tracking-tight">Kebutuhan Bahan Kumulatif</h3>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic mt-1">Dicatat otomatis dari jadwal menu di atas</p>
                            </div>
                            @if(count($requirements) > 0)
                                <a href="{{ route('orders.create', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-royal-navy text-white text-[9px] font-black uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-gold hover:text-royal-navy transition-all flex items-center">
                                    Buat Surat Pesanan
                                    <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                </a>
                            @endif
                        </div>
                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-50">
                                        <th class="px-4 py-3 text-left text-[9px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                        <th class="px-4 py-3 text-right text-[9px] font-black text-gray-400 uppercase tracking-widest">Kebutuhan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($requirements as $matId => $req)
                                        <tr class="hover:bg-silk/50 transition-colors">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-royal-navy">{{ $req['name'] }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-right">
                                                <span class="text-sm font-black text-royal-navy">{{ number_format($req['total'], 2) }}</span>
                                                <span class="text-[10px] font-bold text-gray-400 ml-1 uppercase">{{ $req['unit'] }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-12 text-center text-gray-300 text-xs font-bold uppercase tracking-widest italic">Pilih tanggal dan menu untuk melihat rekap kebutuhan...</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Detailed Arus Bahan Harian -->
                <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-lg font-black text-royal-navy font-playfair tracking-tight">Rincian Arus Bahan</h3>
                            <div class="px-4 py-1.5 bg-silk rounded-full text-[10px] font-black text-gray-400 uppercase tracking-widest">Transaksional</div>
                        </div>
                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-50">
                                        <th class="px-4 py-3 text-left text-[9px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                        <th class="px-4 py-3 text-right text-[9px] font-black text-gray-400 uppercase tracking-widest">Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($logs as $log)
                                        <tr class="hover:bg-silk/50 transition-colors">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-6 h-6 rounded-lg bg-royal-navy/5 flex items-center justify-center text-royal-navy mr-2">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                    </div>
                                                    <span class="text-sm font-bold text-royal-navy">{{ $log->material->name }}</span>
                                                    <span class="ml-2 text-[8px] font-black uppercase px-2 py-0.5 rounded {{ $log->type == 'in' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">{{ $log->type }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-right font-black text-sm {{ $log->type == 'in' ? 'text-emerald-500' : 'text-rose-500' }}">
                                                {{ $log->type == 'in' ? '+' : '-' }} {{ number_format($log->quantity, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-12 text-center text-gray-300 text-xs font-bold uppercase tracking-widest italic">Data belum tersedia...</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Received Orders Section -->
            <div class="mt-8 bg-white rounded-[3rem] shadow-2xl border border-gray-50 overflow-hidden">
                <div class="p-10">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-black text-royal-navy font-playfair tracking-tight">Rekap Penerimaan Barang (via PO)</h3>
                        <div class="px-4 py-1.5 bg-emerald-50 rounded-full text-[10px] font-black text-emerald-600 uppercase tracking-widest">Verified Receipts</div>
                    </div>
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-50">
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">PO Number</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Supplier</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Items</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($received_orders as $order)
                                    <tr class="hover:bg-silk/50 transition-colors group">
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="text-sm font-black text-royal-navy uppercase tracking-tight">#PO-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-600">{{ $order->supplier->name }}</div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($order->items as $item)
                                                    <span class="text-[9px] font-bold px-2 py-1 bg-silk rounded-md text-royal-navy uppercase">{{ $item->material->name }}: {{ number_format($item->requested_quantity, 1) }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right font-black text-royal-navy">
                                            Rp {{ number_format($order->items->sum(function($i){ return $i->requested_quantity * $i->price; })) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-300 text-xs font-bold uppercase tracking-widest italic">Belum ada PO yang diterima hari ini...</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
