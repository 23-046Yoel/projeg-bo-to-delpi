<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Modul Pengolahan') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Laporan Pengolahan Menu</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Button Removed -->
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="mb-8">
                <form action="{{ route('production.processing.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="w-full md:w-64">
                        <label for="sppg_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-2">Filter Dapur (SPPG)</label>
                        <select name="sppg_id" id="sppg_id" onchange="this.form.submit()" class="w-full px-5 py-3 bg-white border-2 border-transparent rounded-xl text-xs font-bold text-royal-navy shadow-lg shadow-royal-navy/5 focus:border-gold outline-none transition-all">
                            <option value="">-- SEMUA DAPUR --</option>
                            @foreach($sppgs as $sppg)
                                <option value="{{ $sppg->id }}" {{ request('sppg_id') == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div class="premium-card overflow-hidden">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-royal-navy/10">
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Tanggal & Dapur</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Menu</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Status</th>
                                    <th class="px-4 py-4 text-center text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($menus as $menu)
                                    <tr class="hover:bg-gold/5 transition-colors group">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <div class="text-[10px] font-black text-gold-dark uppercase tracking-widest mb-1">{{ $menu->sppg->name ?? 'SEMUA DAPUR' }}</div>
                                                <div class="flex items-center">
                                                    <div class="text-sm font-black text-royal-navy">{{ \Carbon\Carbon::parse($menu->date)->translatedFormat('d M Y') }}</div>
                                                    <span class="mx-2 text-gray-300">|</span>
                                                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($menu->date)->translatedFormat('l') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-semibold text-gray-700">
                                                {{ $menu->karbo ?: 'Menu ' . $menu->id }}
                                            </div>
                                            <div class="text-[10px] text-gray-400">{{ $menu->dishes->pluck('name')->implode(', ') }}</div>
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($menu->processings->count() > 0)
                                                <span class="px-3 py-1 bg-green-100 text-green-600 text-[10px] font-black uppercase rounded-full tracking-wider">Sudah Diisi</span>
                                            @else
                                                <span class="px-3 py-1 bg-amber-100 text-amber-600 text-[10px] font-black uppercase rounded-full tracking-wider">Belum Diisi</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('production.processing.show', $menu) }}" class="inline-flex items-center px-4 py-2 bg-gold text-royal-navy text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gold/80 transition-all shadow-lg shadow-gold/20">
                                                Isi Laporan
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <p class="text-gray-400 font-bold uppercase tracking-wider text-sm">Belum ada menu</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($menus->hasPages())
                    <div class="mt-8 px-4">
                        {{ $menus->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
