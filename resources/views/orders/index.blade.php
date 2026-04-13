<x-app-layout>
    <div class="py-12 bg-[#0a192f] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-md overflow-hidden shadow-2xl rounded-2xl border border-white/10 p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                    <div>
                        <h2 class="text-4xl font-serif text-[#d4af37] tracking-wider mb-2 uppercase">Surat Pesanan</h2>
                        <div class="flex items-center space-x-3">
                            <span class="w-10 h-[1px] bg-[#d4af37]/50"></span>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-none">Pemesanan Bahan Baku & Rekap Harian</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('orders.daily') }}" class="px-8 py-3 bg-white/5 border border-[#d4af37]/30 text-[#d4af37] rounded-xl font-black uppercase tracking-[0.2em] text-[10px] hover:bg-[#d4af37]/10 transition-all">
                            Rekap Harian
                        </a>
                        <a href="{{ route('orders.create') }}" class="bg-[#d4af37] text-[#0a192f] px-8 py-3 rounded-xl font-bold hover:bg-[#c19b2e] transition-all transform hover:scale-105 shadow-2xl shadow-[#d4af37]/20 flex items-center gap-2 uppercase tracking-[0.2em] text-[10px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            Buat Surat Pesanan
                        </a>
                    </div>
                </div>

                <div class="mb-10 bg-white/5 p-6 rounded-xl border border-white/10">
                    <form action="{{ route('orders.index') }}" method="GET" class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Filter Tanggal:</label>
                            <input type="date" name="date" value="{{ request('date') }}" 
                                class="bg-[#0a192f] border-none text-xs font-bold text-[#d4af37] rounded-lg focus:ring-1 focus:ring-[#d4af37] outline-none px-4 py-2">
                        </div>

                        <div class="flex items-center gap-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Supplier:</label>
                            <select name="supplier_id" onchange="this.form.submit()" 
                                class="bg-[#0a192f] border-none text-xs font-bold text-[#d4af37] rounded-lg focus:ring-1 focus:ring-[#d4af37] outline-none px-4 py-2 min-w-[150px]">
                                <option value="">Semua Supplier (All)</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-6 py-2 bg-[#d4af37]/10 text-[#d4af37] text-[10px] font-bold uppercase rounded-lg hover:bg-[#d4af37]/20 transition-all">
                                Cari
                            </button>
                            @if(request('date') || request('supplier_id'))
                                <a href="{{ route('orders.index') }}" class="text-[10px] font-bold text-red-400/50 uppercase hover:text-red-400 transition-colors">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($orders as $order)
                    <div class="bg-white/5 rounded-2xl border border-white/10 p-6 hover:border-[#d4af37]/50 transition-all group relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest 
                                {{ $order->status == 'pending' ? 'bg-amber-500/20 text-amber-500' : 'bg-emerald-500/20 text-emerald-500' }}">
                                {{ $order->status }}
                            </span>
                        </div>
                        <h3 class="text-xl font-serif text-white mb-1 group-hover:text-[#d4af37] transition-colors">#SP{{ $order->id }} - {{ $order->supplier->name }}</h3>
                        <p class="text-gray-400 text-xs mb-4">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                        
                        <div class="space-y-2 mb-6 text-sm">
                            @foreach($order->items as $item)
                            <div class="flex justify-between text-gray-300">
                                <span>{{ $item->material->name }}</span>
                                <span class="text-white font-medium">{{ number_format($item->requested_quantity) }} {{ $item->unit }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="pt-4 border-t border-white/10 mt-auto flex justify-between items-center">
                            <span class="text-[#d4af37] font-bold">Rp {{ number_format($order->total_amount) }}</span>
                            <a href="{{ route('orders.show', $order) }}" class="text-white/40 hover:text-[#d4af37] transition-colors" title="Print PO">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
