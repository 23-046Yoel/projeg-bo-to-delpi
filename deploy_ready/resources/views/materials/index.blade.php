<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-playfair font-black text-3xl text-royal-navy leading-tight tracking-tight">
                    {{ __('Materials Inventory') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">Manage and monitor your raw materials and stock levels.</p>
            </div>
            <a href="{{ route('materials.create') }}" class="btn-premium scale-90 md:scale-100">
                <span class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add New Material</span>
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Summary (Optional but adds value) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="premium-card p-6 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-gold/10 flex items-center justify-center text-gold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Items</p>
                        <p class="text-2xl font-black text-royal-navy leading-none mt-1">{{ $materials->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gold/10 relative">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-royal-navy">
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Material Name</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Category</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Unit</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Price</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Current Stock</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 bg-white/30">
                            @foreach ($materials as $material)
                                <tr class="hover:bg-gold/5 transition-all duration-300 group">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 rounded-full mr-3 {{ $material->stock <= 0 ? 'bg-red-500 animate-pulse' : 'bg-gold' }}"></div>
                                            <span class="text-sm font-bold text-royal-navy group-hover:text-gold-dark transition-colors capitalize underline decoration-gold/0 decoration-2 underline-offset-4 group-hover:decoration-gold/30">{{ $material->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $material->type == 'raw' ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600' }}">
                                            {{ $material->type }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-xs font-bold text-slate-600 tracking-tight">{{ $material->unit ?? '-' }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-sm font-black text-royal-navy">Rp {{ number_format($material->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-baseline space-x-1">
                                            <span class="text-lg font-black {{ $material->stock <= 0 ? 'text-red-600' : 'text-royal-navy' }}">
                                                {{ number_format($material->stock, 2) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right">
                                        <a href="{{ route('materials.edit', $material) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-silk border border-gold/10 text-gold-dark hover:bg-royal-navy hover:text-gold transition-all duration-300 shadow-sm active:scale-90">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination Styling Meta-info -->
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-400 tracking-wide uppercase">
                        Showing <span class="text-royal-navy">{{ $materials->firstItem() }}</span> to <span class="text-royal-navy">{{ $materials->lastItem() }}</span> of <span class="text-royal-navy">{{ $materials->total() }}</span> materials
                    </p>
                    <div class="premium-pagination">
                        {{ $materials->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
