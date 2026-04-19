<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('suppliers.index') }}" class="text-[10px] font-black text-gray-400 hover:text-gold transition-colors uppercase tracking-[0.2em] mb-2 inline-block">&larr; Kembali ke Daftar Partner</a>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Detail Supplier: ') }} {{ $supplier->name }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">ID: #SUP-{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}</p>
            </div>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="group relative px-8 py-3 bg-gold rounded-2xl font-black text-xs text-royal-navy uppercase tracking-[0.2em] shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all duration-300 transform hover:-translate-y-1">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Data
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-10">
                    
                    <div class="flex items-center mb-10 pb-10 border-b border-gray-50">
                        <div class="w-24 h-24 rounded-[2rem] bg-royal-navy shadow-2xl shadow-royal-navy/20 flex items-center justify-center text-gold mr-8 rotate-3">
                            <span class="font-black text-4xl font-playfair">{{ substr($supplier->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-3xl font-black text-royal-navy font-playfair tracking-tight mb-2">{{ $supplier->name }}</h3>
                            <div class="flex items-center space-x-4">
                                <span class="px-4 py-1.5 bg-gold/10 text-gold-dark text-[10px] font-black rounded-xl uppercase tracking-widest">
                                    {{ $supplier->sppg->name ?? 'ALL SPPG' }}
                                </span>
                                <span class="text-xs font-bold text-gray-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $supplier->village ?? 'Belum ada alamat' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <div class="mb-8 group">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-gold transition-colors">Nomor Telepon/WA</label>
                                <div class="text-lg font-bold text-royal-navy flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $supplier->phone ?? '-' }}
                                    @if($supplier->phone)
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $supplier->phone)) }}" target="_blank" class="ml-3 px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-lg uppercase tracking-wider hover:bg-green-100">Chat WA</a>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-8 group">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 group-hover:text-gold transition-colors">Tanggal Terdaftar</label>
                                <div class="text-base font-bold text-royal-navy">
                                    {{ $supplier->created_at->format('d F Y (H:i)') }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="h-full bg-silk/50 rounded-[2rem] p-8 border border-gray-100 relative overflow-hidden group hover:border-gold/30 transition-all">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gold/5 -mr-16 -mt-16 rounded-full group-hover:bg-gold/10 transition-colors"></div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Komoditas / Barang yang Dijual</label>
                                <div class="text-sm font-bold text-royal-navy leading-relaxed">
                                    @if($supplier->items)
                                        {!! nl2br(e($supplier->items)) !!}
                                    @else
                                        <span class="text-gray-400 italic font-medium">Belum ada daftar barang.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
