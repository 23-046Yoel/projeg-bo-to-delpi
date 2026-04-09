<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen print:bg-white print:py-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-none md:rounded-3xl overflow-hidden border border-gray-100 print:shadow-none print:border-none">
                <!-- Header / Brand -->
                <div class="p-8 md:p-12 border-b border-gray-100 flex justify-between items-start">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-royal-navy rounded-xl flex items-center justify-center text-gold font-black text-xl">D</div>
                            <h1 class="text-2xl font-black text-royal-navy tracking-tight uppercase">Bo To Delpi</h1>
                        </div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest leading-none">Satuan Pelayanan Program Gizi</p>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest font-bold">{{ auth()->user()->sppg->name ?? 'Unit SPPG' }}</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-4xl font-black text-royal-navy/10 uppercase tracking-tighter leading-none mb-2">Purchase Order</h2>
                        <p class="text-sm font-black text-royal-navy uppercase tracking-widest">#SP{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-0 border-b border-gray-100">
                    <div class="p-8 md:p-12 border-r border-gray-100">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 text-royal-navy">Supplier Information</h3>
                        <p class="text-xl font-black text-royal-navy mb-1">{{ $order->supplier->name }}</p>
                        <p class="text-sm text-gray-500 font-medium">{{ $order->supplier->address }}</p>
                        <p class="text-sm text-gray-500 font-medium">{{ $order->supplier->phone }}</p>
                    </div>
                    <div class="p-8 md:p-12">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 text-royal-navy">Order Details</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</span>
                                <span class="text-sm font-black text-royal-navy uppercase">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</span>
                                <span class="px-3 py-1 bg-royal-navy/5 text-royal-navy rounded-full text-[10px] font-black uppercase tracking-widest">{{ $order->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="p-8 md:p-12">
                    <table class="w-full mb-12">
                        <thead>
                            <tr class="border-b-2 border-royal-navy/10">
                                <th class="py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Material Name</th>
                                <th class="py-4 text-center text-[10px] font-black text-royal-navy uppercase tracking-widest">Qty</th>
                                <th class="py-4 text-right text-[10px] font-black text-royal-navy uppercase tracking-widest">Price</th>
                                <th class="py-4 text-right text-[10px] font-black text-royal-navy uppercase tracking-widest">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="py-6">
                                    <p class="text-sm font-black text-royal-navy">{{ $item->material->name }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bahan Baku</p>
                                </td>
                                <td class="py-6 text-center">
                                    <span class="text-sm font-black text-royal-navy">{{ number_format($item->requested_quantity) }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase ml-1">{{ $item->unit }}</span>
                                </td>
                                <td class="py-6 text-right text-sm font-medium text-gray-500">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="py-6 text-right text-sm font-black text-royal-navy">
                                    Rp {{ number_format($item->requested_quantity * $item->price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-royal-navy pt-6">
                                <td colspan="3" class="py-8 text-right text-[10px] font-black text-royal-navy uppercase tracking-[0.2em]">Total Amount</td>
                                <td class="py-8 text-right text-2xl font-black text-royal-navy">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Notes -->
                    <div class="grid grid-cols-2 gap-12 mt-12">
                        <div>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Notes & Instructions</h4>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed italic">
                                Sesuai dengan petunjuk teknis Badan Gizi Nasional (BGN), harap kirimkan bahan baku tepat waktu dengan kualitas terbaik. Sertakan invoice saat pengiriman.
                            </p>
                        </div>
                        <div class="text-center pt-8">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-12">Authorized Signature</h4>
                            <div class="w-48 h-px bg-gray-200 mx-auto mb-2"></div>
                            <p class="text-xs font-black text-royal-navy uppercase tracking-widest">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kepala Unit SPPG</p>
                        </div>
                    </div>
                </div>

                <!-- Footer / Action -->
                <div class="p-8 bg-silk print:hidden flex justify-center space-x-4">
                    <button onclick="window.print()" class="px-8 py-4 bg-royal-navy text-gold font-black text-[10px] uppercase tracking-[0.3em] rounded-2xl shadow-xl hover:-translate-y-1 transition-all">
                        Print PO
                    </button>
                    <a href="{{ route('orders.index') }}" class="px-8 py-4 bg-white border border-gray-200 text-royal-navy font-black text-[10px] uppercase tracking-[0.3em] rounded-2xl hover:bg-gray-50 transition-all">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
