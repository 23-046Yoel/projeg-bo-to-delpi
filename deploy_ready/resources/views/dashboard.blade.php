<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                {{ __('Executive Overview') }}
            </h2>
            <div class="flex items-center space-x-2 text-xs font-bold text-gray-400 tracking-widest uppercase">
                <span>Portal</span>
                <span class="text-gold">/</span>
                <span class="text-royal-navy">Dashboard</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-12 text-center">
                <h3 class="text-4xl font-black text-royal-navy mb-3 font-playfair tracking-tight">Sistem BoTo Delphi</h3>
                <div class="h-1 w-20 bg-gold mx-auto rounded-full mb-4"></div>
                <p class="text-gray-500 font-medium tracking-wide">Ringkasan operasional dan statistik real-time SPPG.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- Suppliers -->
                <div class="bg-white p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 hover:border-gold/30 transition-all duration-500 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 sm:w-32 h-24 sm:h-32 bg-gold/5 -mr-12 sm:-mr-16 -mt-12 sm:-mt-16 rounded-full group-hover:bg-gold/10 transition-colors"></div>
                    <div class="relative">
                        <div class="text-gray-400 font-black uppercase tracking-[0.2em] text-[10px] mb-3 sm:mb-4">Total Suppliers</div>
                        <div class="flex items-end justify-between">
                            <div class="text-royal-navy text-4xl sm:text-5xl font-black font-playfair leading-none">{{ $stats['suppliers_count'] }}</div>
                            <div class="w-10 h-10 rounded-xl bg-gold/10 flex items-center justify-center text-gold group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Beneficiaries -->
                <div class="bg-white p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 hover:border-gold/30 transition-all duration-500 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 sm:w-32 h-24 sm:h-32 bg-gold/5 -mr-12 sm:-mr-16 -mt-12 sm:-mt-16 rounded-full group-hover:bg-gold/10 transition-colors"></div>
                    <div class="relative">
                        <div class="text-gray-400 font-black uppercase tracking-[0.2em] text-[10px] mb-3 sm:mb-4">Penerima Manfaat</div>
                        <div class="flex items-end justify-between">
                            <div class="text-royal-navy text-4xl sm:text-5xl font-black font-playfair leading-none">{{ $stats['beneficiaries_count'] }}</div>
                            <div class="w-10 h-10 rounded-xl bg-gold/10 flex items-center justify-center text-gold group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Materials -->
                <div class="bg-white p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 hover:border-gold/30 transition-all duration-500 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 sm:w-32 h-24 sm:h-32 bg-gold/5 -mr-12 sm:-mr-16 -mt-12 sm:-mt-16 rounded-full group-hover:bg-gold/10 transition-colors"></div>
                    <div class="relative">
                        <div class="text-gray-400 font-black uppercase tracking-[0.2em] text-[10px] mb-3 sm:mb-4">Item Bahan Baku</div>
                        <div class="flex items-end justify-between">
                            <div class="text-royal-navy text-4xl sm:text-5xl font-black font-playfair leading-none">{{ $stats['materials_count'] }}</div>
                            <div class="w-10 h-10 rounded-xl bg-gold/10 flex items-center justify-center text-gold group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payments -->
                <div class="bg-royal-navy p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_20px_50px_rgba(15,23,42,0.1)] border border-royal-navy transition-all duration-500 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 sm:w-32 h-24 sm:h-32 bg-white/5 -mr-12 sm:-mr-16 -mt-12 sm:-mt-16 rounded-full"></div>
                    <div class="relative">
                        <div class="text-gray-400 font-black uppercase tracking-[0.2em] text-[10px] mb-3 sm:mb-4">Total Realisasi Dana</div>
                        <div class="flex items-end justify-between">
                            <div class="text-white text-2xl sm:text-3xl font-black font-playfair leading-none tracking-tight">
                                <span class="text-gold text-lg mr-1 italic">Rp</span>{{ number_format($stats['total_payments'], 0, ',', '.') }}
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gold flex items-center justify-center text-royal-navy group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
