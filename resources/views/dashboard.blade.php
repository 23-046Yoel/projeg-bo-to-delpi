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
                <a href="{{ route('suppliers.index') }}" class="block bg-white p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 hover:border-gold/30 transition-all duration-500 group relative overflow-hidden">
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
                </a>

                <!-- Beneficiaries -->
                <a href="{{ route('beneficiary-groups.index') }}" class="block bg-white p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 hover:border-gold/30 transition-all duration-500 group relative overflow-hidden">
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
                </a>

                <!-- Materials -->
                <a href="{{ route('materials.index') }}" class="block bg-white p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 hover:border-gold/30 transition-all duration-500 group relative overflow-hidden">
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
                </a>

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
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.407 2.67 1m-4.67 1c.59-1.326 2.148-2.31 3.75-2.31 1.602 0 3.16 1.157 3.75 2.5a5.952 5.952 0 010 4.3c-.59 1.343-2.148 2.5-3.75 2.5-1.602 0-3.16-1.002-3.75-2.25M12 18a9 9 0 110-18 9 9 0 010 18z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Lists Section -->
            <div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Latest Suppliers -->
                <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                        <div>
                            <h4 class="font-playfair font-black text-xl text-royal-navy">Pendaftar Pemasok Terbaru</h4>
                            <p class="text-[10px] font-bold text-gold uppercase tracking-[0.2em] mt-1">Calon Mitra Rantai Pasok</p>
                        </div>
                        <a href="{{ route('suppliers.index') }}" class="text-[10px] font-black text-royal-navy hover:text-gold transition-colors uppercase tracking-widest border-b-2 border-gold pb-1">Lihat Semua</a>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama / Usaha</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Dapur Tujuan</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Komoditas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($latest_suppliers as $supplier)
                                <tr onclick="window.location='{{ route('suppliers.show', $supplier) }}'" class="hover:bg-gray-50/30 transition-colors cursor-pointer group">
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-royal-navy text-sm group-hover:text-gold transition-colors">{{ $supplier->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium">{{ $supplier->village }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="px-3 py-1 bg-royal-navy/5 text-royal-navy text-[10px] font-extrabold rounded-full">{{ $supplier->sppg->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-xs text-gray-500 line-clamp-1">{{ $supplier->items }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-10 text-center text-gray-400 text-xs italic font-medium">Belum ada pendaftar baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Latest Complaints -->
                <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                        <div>
                            <h4 class="font-playfair font-black text-xl text-royal-navy">Laporan Pengaduan Terbaru</h4>
                            <p class="text-[10px] font-bold text-red-500 uppercase tracking-[0.2em] mt-1">Layanan Aspirasi & Keluhan</p>
                        </div>
                        <a href="{{ route('complaints.index') }}" class="text-[10px] font-black text-royal-navy hover:text-red-500 transition-colors uppercase tracking-widest border-b-2 border-red-500 pb-1">Lihat Semua</a>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pelapor</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Masalah</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($latest_complaints as $complaint)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-royal-navy text-sm">{{ $complaint->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium">{{ $complaint->phone }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-xs font-bold text-gray-600">{{ $complaint->type }}</div>
                                        <div class="text-[10px] text-gray-400 line-clamp-1 italic">"{{ $complaint->description }}"</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        @php
                                            $badgeClass = match($complaint->status) {
                                                'Selesai' => 'bg-emerald-100 text-emerald-700',
                                                'Diproses' => 'bg-blue-100 text-blue-700',
                                                default => 'bg-amber-100 text-amber-700',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 {{ $badgeClass }} text-[10px] font-extrabold rounded-full">{{ $complaint->status }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-10 text-center text-gray-400 text-xs italic font-medium">Belum ada laporan pengaduan.</td>
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
