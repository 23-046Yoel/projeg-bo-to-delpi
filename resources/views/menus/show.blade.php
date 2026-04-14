<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('menus.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Rencana Penggunaan Bahan') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Estimasi Kebutuhan Bahan: {{ \Carbon\Carbon::parse($menu->date)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Dishes Recap -->
            <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 p-8">
                <h3 class="text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-6">Menu yang Direncanakan (Porsi Ganda)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($menu->dishes as $dish)
                        <div class="p-6 bg-silk rounded-2xl border border-transparent hover:border-gold/30 transition-all group relative">
                            @if($dish->recipes->count() == 0)
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg animate-pulse" title="Resep belum diatur!">
                                    <span class="text-[10px] font-black">!</span>
                                </div>
                            @endif
                            <div class="text-xs font-black text-royal-navy uppercase tracking-tight mb-3 group-hover:text-gold transition-colors">{{ $dish->name }}</div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Besar</div>
                                    <div class="text-xl font-black text-royal-navy">{{ $dish->pivot->porsi_besar }}</div>
                                </div>
                                <div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kecil</div>
                                    <div class="text-xl font-black text-royal-navy">{{ $dish->pivot->porsi_kecil }}</div>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center font-bold text-royal-navy/40">
                                <span class="text-[9px] uppercase tracking-widest">Total</span>
                                <span class="text-xs">{{ $dish->pivot->porsi_besar + $dish->pivot->porsi_kecil }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($menu->dishes->contains(fn($d) => $d->recipes->count() == 0))
                    <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center text-white shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-red-600 uppercase tracking-widest leading-none mb-1">Peringatan Resep!</p>
                            <p class="text-xs text-red-500">Ada hidangan yang belum diatur bahan bakunya. Silakan isi resep di menu <b>Daftar Hidangan (Resep)</b> agar kalkulasi muncul otomatis.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Material Requirements -->
            <div class="bg-white rounded-[2rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-[10px] font-black text-royal-navy uppercase tracking-[0.2em]">Kebutuhan Bahan Baku (Otomatis)</h3>
                            <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest text-wrap">Dihitung otomatis: (Porsi Besar + Porsi Kecil) x Resep</p>
                        </div>
                    </div>

                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-50">
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Material Item</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Current Stock</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Needed Quantity</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Unit</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($requirements as $matId => $req)
                                @php
                                    $material = \App\Models\Material::find($matId);
                                    // Calculate simple balance (this should be more robust in production)
                                    $masuk = $material->logs()->where('type', 'in')->sum('quantity');
                                    $keluar = $material->logs()->where('type', 'out')->sum('quantity');
                                    $stock = $masuk - $keluar;
                                    $isRunningLow = $stock < $req['total'];
                                @endphp
                                <tr class="hover:bg-silk/50 transition-colors">
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="text-sm font-bold text-royal-navy">{{ $req['name'] }}</div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="text-sm font-black {{ $isRunningLow ? 'text-red-500' : 'text-green-600' }}">
                                            {{ number_format($stock, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="text-lg font-black text-royal-navy">{{ number_format($req['total'], 2) }}</div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-royal-navy/5 text-royal-navy rounded-md text-[10px] font-black uppercase tracking-tight">{{ $req['unit'] }}</span>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-right">
                                        @if($isRunningLow)
                                            <span class="px-3 py-1 bg-red-50 text-red-500 rounded-lg text-[10px] font-black uppercase tracking-wider border border-red-100 flex items-center justify-center inline-flex">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                Need Purchase
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-black uppercase tracking-wider border border-green-100 flex items-center justify-center inline-flex">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                Stock Ready
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 px-4 sm:px-0">
                 <a href="{{ route('menus.edit', $menu) }}" class="px-8 py-4 bg-silk text-royal-navy border border-gray-200 font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-100 transition-all">
                    Edit Perencanaan
                </a>
                 <a href="{{ route('orders.create', ['menu_id' => $menu->id]) }}" class="px-10 py-4 bg-gold text-royal-navy font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl shadow-gold/20 hover:bg-gold/80 hover:-translate-y-1 transition-all duration-300">
                    Buat Surat Pesanan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
