<x-app-layout>
    <div class="py-12 bg-[#0a192f] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-md overflow-hidden shadow-2xl rounded-2xl border border-white/10 p-8">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-4xl font-serif text-[#d4af37] tracking-wider mb-2">Surat Pesanan</h2>
                        <p class="text-gray-400 font-light italic">Daftar pemesanan bahan baku ke supplier untuk keberlanjutan MBG.</p>
                    </div>
                    <a href="{{ route('orders.create') }}" class="bg-[#d4af37] text-[#0a192f] px-8 py-3 rounded-xl font-bold hover:bg-[#c19b2e] transition-all transform hover:scale-105 shadow-2xl shadow-[#d4af37]/20 flex items-center gap-2 uppercase tracking-widest text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Surat Pesanan
                    </a>
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
                            <button class="text-white/40 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
