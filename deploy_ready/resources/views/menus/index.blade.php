<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Daily Menus') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Perencanaan Menu & Kalkulasi Bahan Otomatis</p>
            </div>
            <a href="{{ route('menus.create') }}" class="group relative px-8 py-3 bg-gold rounded-2xl font-black text-xs text-royal-navy uppercase tracking-[0.2em] shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all duration-300 transform hover:-translate-y-1">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Daily Menu
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
                                <tr class="border-b border-gray-50">
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Menu Date</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hidden sm:table-cell">Kitchen</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Dish Count</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($menus as $menu)
                                    <tr class="hover:bg-silk/50 transition-colors group">
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-royal-navy shadow-lg shadow-royal-navy/20 flex items-center justify-center text-gold mr-3 sm:mr-4 group-hover:rotate-6 transition-transform">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                                <div>
                                                    <div class="text-[11px] sm:text-sm font-black text-royal-navy tracking-tight">{{ \Carbon\Carbon::parse($menu->date)->translatedFormat('d F Y') }}</div>
                                                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">#PLN-{{ str_pad($menu->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                                                {{ $menu->sppg->name ?? 'ALL KITCHENS' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-royal-navy/5 text-royal-navy rounded-lg text-[9px] sm:text-[10px] font-black uppercase tracking-wider">
                                                {{ $menu->dishes_count }} <span class="hidden sm:inline">Dishes</span><span class="sm:hidden">D</span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right space-x-1 sm:space-x-2">
                                            <a href="{{ route('menus.show', $menu) }}" title="Check Requirements" class="inline-flex items-center p-2 sm:px-4 sm:py-2 bg-royal-navy text-gold rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy/90 shadow-lg shadow-royal-navy/10 transition-all">
                                                <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                <span class="hidden sm:inline">Check</span>
                                            </a>
                                            <a href="{{ route('menus.edit', $menu) }}" title="Edit" class="inline-flex items-center p-2 sm:px-4 sm:py-2 border-2 border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:border-gold hover:text-royal-navy transition-all">
                                                <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span class="hidden sm:inline">Edit</span>
                                            </a>
                                            <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus rencana menu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors p-2">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="mt-8 px-6">
                        {{ $menus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
