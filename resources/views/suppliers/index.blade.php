<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Partner Suppliers') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Manajemen Rantai Pasok SPPG</p>
            </div>
            <a href="{{ route('suppliers.create') }}" class="group relative px-8 py-3 bg-gold rounded-2xl font-black text-xs text-royal-navy uppercase tracking-[0.2em] shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all duration-300 transform hover:-translate-y-1">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Partner
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-50">
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Partner Info</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Location</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Commodities (Items)</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Target SPPG</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($suppliers as $supplier)
                                    <tr class="hover:bg-silk/50 transition-colors group">
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-2xl bg-royal-navy shadow-lg shadow-royal-navy/20 flex items-center justify-center text-gold mr-4 group-hover:rotate-6 transition-transform">
                                                    <span class="font-black text-lg">{{ substr($supplier->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-black text-royal-navy tracking-tight">{{ $supplier->name }}</div>
                                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">ID: #SUP-{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center text-sm font-bold text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $supplier->village }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="text-xs font-bold text-royal-navy">{{ $supplier->phone }}</div>
                                            <div class="text-[10px] text-gray-400 italic line-clamp-2 max-w-[200px] mt-1">{{ $supplier->items ?? 'No items listed' }}</div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <span class="px-3 py-1 bg-gold/10 text-gold-dark text-[10px] font-black rounded-lg uppercase tracking-widest">
                                                {{ $supplier->sppg->name ?? 'ALL SPPG' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('suppliers.edit', $supplier) }}" class="inline-flex items-center px-4 py-2 border-2 border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:border-gold hover:text-royal-navy hover:bg-gold/10 transition-all">
                                                    Edit
                                                </a>
                                                @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Hapus partner supplier ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 border-2 border-red-50 rounded-xl text-[10px] font-black uppercase tracking-widest text-red-300 hover:border-red-500 hover:text-red-500 hover:bg-red-50 transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 px-6">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
