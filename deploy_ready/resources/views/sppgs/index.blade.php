<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Management Kitchens') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Pengaturan & Akses Nomor HP Dapur</p>
            </div>
            <a href="{{ route('sppgs.create') }}" class="group relative px-8 py-3 bg-gold rounded-2xl font-black text-xs text-royal-navy uppercase tracking-[0.2em] shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all duration-300 transform hover:-translate-y-1">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Kitchen
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-2xl flex items-center text-green-600 text-sm font-bold">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-50">
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kitchen Name</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Location</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Access Phone</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($sppgs as $sppg)
                                <tr class="hover:bg-silk/50 transition-colors group">
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-2xl bg-royal-navy shadow-lg shadow-royal-navy/20 flex items-center justify-center text-gold mr-4 group-hover:rotate-6 transition-transform">
                                                <span class="font-black text-lg">{{ substr($sppg->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-royal-navy tracking-tight">{{ $sppg->name }}</div>
                                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">KITCHEN CODE: #KTC-{{ str_pad($sppg->id, 3, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <svg class="w-3.5 h-3.5 mr-2 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $sppg->location ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="inline-flex items-center px-3 py-1 bg-royal-navy/5 text-royal-navy rounded-lg text-xs font-black tracking-tight">
                                            <svg class="w-3 h-3 mr-2 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $sppg->phone ?? 'NO ACCESS' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-right space-x-2">
                                        <a href="{{ route('sppgs.edit', $sppg) }}" class="inline-flex items-center px-4 py-2 border-2 border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:border-gold hover:text-royal-navy hover:bg-gold/10 transition-all">
                                            Edit
                                        </a>
                                        <form action="{{ route('sppgs.destroy', $sppg) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus dapur ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-xl text-[10px] font-black uppercase tracking-widest text-red-400 hover:bg-red-50 hover:text-red-500 transition-all">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-8 px-6">
                        {{ $sppgs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
