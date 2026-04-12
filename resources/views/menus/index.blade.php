<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Daftar Menu MBG') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Perencanaan Menu 2 Minggu</p>
            </div>
            <a href="{{ route('menus.create') }}" class="group relative px-8 py-3 bg-gold rounded-2xl font-black text-xs text-royal-navy uppercase tracking-[0.2em] shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all duration-300 transform hover:-translate-y-1">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Tambah Menu
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="premium-card overflow-hidden">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-royal-navy/10">
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Dapur</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Karbo</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Protein Hewani</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Protein Nabati</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Sayur</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Buah</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Pelengkap</th>
                                    <th class="px-4 py-4 text-center text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($menus as $menu)
                                    @php
                                        $menuData = json_decode($menu->content, true) ?? [];
                                    @endphp
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
                                                {{ $menu->karbo ?: ($menu->dishes->count() > 0 ? $menu->dishes[0]->name : '-') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-semibold text-gray-700">
                                                {{ $menu->protein_hewani ?: ($menu->dishes->count() > 1 ? $menu->dishes[1]->name : '-') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-semibold text-gray-700">
                                                {{ $menu->protein_nabati ?: ($menu->dishes->count() > 2 ? $menu->dishes[2]->name : '-') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-semibold text-gray-700">
                                                {{ $menu->sayur ?: ($menu->dishes->count() > 3 ? $menu->dishes[3]->name : '-') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-semibold text-gray-700">
                                                {{ $menu->buah ?: ($menu->dishes->count() > 4 ? $menu->dishes[4]->name : '-') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-semibold text-gray-700">
                                                {{ $menu->pelengkap ?: ($menu->dishes->count() > 5 ? $menu->dishes[5]->name : '-') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('menus.show', $menu) }}" title="Lihat Detail" class="inline-flex items-center p-2 bg-royal-navy text-gold rounded-lg text-[10px] font-black hover:bg-royal-navy/90 shadow-md transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                                <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus menu ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                <p class="text-gray-400 font-bold uppercase tracking-wider text-sm">Belum ada menu</p>
                                                <p class="text-gray-300 text-xs mt-1">Klik tombol "Tambah Menu" untuk membuat menu baru</p>
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
