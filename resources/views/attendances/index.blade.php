<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-playfair font-black text-3xl text-royal-navy leading-tight tracking-tight">
                    {{ __('Laporan Absensi Relawan') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Monitoring Kehadiran STAFF & VOLUNTEER secara Real-time</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="px-4 py-2 bg-emerald-50 rounded-xl border border-emerald-100 flex items-center space-x-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Sistem Aktif</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="flex items-center space-x-2 mb-6 overflow-x-auto pb-2 custom-scrollbar">
                <a href="{{ route('attendances.index') }}" 
                   class="px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('sppg_id') ? 'bg-royal-navy text-gold shadow-lg ring-2 ring-gold/20' : 'bg-white text-gray-400 border border-gray-100 hover:bg-silk' }}">
                    SEMUA LOKASI
                </a>
                @foreach($sppgs as $s)
                    <a href="{{ route('attendances.index', ['sppg_id' => $s->id]) }}" 
                       class="px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('sppg_id') == $s->id ? 'bg-royal-navy text-gold shadow-lg ring-2 ring-gold/20' : 'bg-white text-gray-400 border border-gray-100 hover:bg-silk whitespace-nowrap' }}">
                        {{ $s->name }}
                    </a>
                @endforeach
            </div>

            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gold/10 relative">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gold/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                
                <div class="overflow-x-auto custom-scrollbar relative z-10">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-gradient-to-r from-royal-navy to-royal-navy/90">
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Relawan & Cabang</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Waktu Presensi</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Koordinat GPS</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Lokasi / Alamat</th>
                                <th class="px-8 py-6 text-center text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 bg-white/30 backdrop-blur-md">
                            @forelse ($attendances as $attendance)
                                <tr class="hover:bg-gold/5 transition-all duration-300 group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-2xl bg-royal-navy flex items-center justify-center text-gold font-black text-xs shadow-lg group-hover:scale-110 transition-transform duration-500 mr-4">
                                                {{ substr($attendance->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <span class="block text-sm font-black text-royal-navy uppercase tracking-tight">{{ $attendance->user->name }}</span>
                                                <div class="flex items-center space-x-1.5 mt-0.5">
                                                    <span class="text-[9px] font-bold text-gold-dark uppercase tracking-widest">{{ $attendance->user->role ?? 'Relawan' }}</span>
                                                    <span class="text-[9px] font-bold text-gray-300">•</span>
                                                    <span class="text-[9px] font-black text-royal-navy/60 uppercase tracking-widest px-1.5 py-0.5 bg-silk rounded border border-royal-navy/10">{{ $attendance->sppg->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-royal-navy">{{ $attendance->created_at->translatedFormat('d M Y') }}</span>
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $attendance->created_at->format('H:i') }} WIB</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" 
                                           target="_blank" 
                                           class="inline-flex items-center px-4 py-2 bg-silk border border-gold/10 rounded-xl text-xs font-black text-royal-navy hover:bg-gold hover:text-white transition-all shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            MAPS
                                        </a>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="max-w-xs">
                                            <p class="text-[11px] font-bold text-slate-600 leading-relaxed italic line-clamp-1">
                                                {{ $attendance->address ?? 'Lokasi GPS Tercatat' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $attendance->status == 'in' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                                            {{ $attendance->status == 'in' ? 'Check In' : 'Check Out' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-silk rounded-[2rem] flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Belum ada data absensi yang tercatat hari ini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-[10px] font-black text-slate-400 tracking-wide uppercase">
                        TOTAL RECORD: <span class="text-royal-navy">{{ $attendances->total() }}</span> PRESENSI
                    </p>
                    <div class="premium-pagination">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
