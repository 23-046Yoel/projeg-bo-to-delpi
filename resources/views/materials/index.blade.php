<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-playfair font-black text-3xl text-royal-navy leading-tight tracking-tight">
                    {{ __('Manajemen Bahan Baku') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">Kelola dan pantau stok bahan baku SPPG Anda.</p>
            </div>
            <a href="{{ route('materials.create') }}" class="btn-premium scale-90 md:scale-100">
                <span class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambahkan Bahan Baku</span>
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
                <div class="premium-card p-6 flex items-center space-x-4 w-full md:w-auto">
                    <div class="w-12 h-12 rounded-2xl bg-gold/10 flex items-center justify-center text-gold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Items</p>
                        <p class="text-2xl font-black text-royal-navy leading-none mt-1">{{ $materials->total() }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
                    @if(auth()->user()->isAdmin())
                    <form action="{{ route('materials.index') }}" method="GET" class="w-full md:w-64">
                        <select name="sppg_id" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-4 bg-white border-2 border-gold/5 rounded-2xl text-xs font-bold text-royal-navy focus:border-gold focus:ring-4 focus:ring-gold/10 outline-none transition-all shadow-xl shadow-royal-navy/5">
                            <option value="">Semua Dapur</option>
                            @foreach($sppgs as $sppg)
                                <option value="{{ $sppg->id }}" {{ request('sppg_id') == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                            @endforeach
                        </select>
                    </form>
                    @endif

                    <form action="{{ route('materials.index') }}" method="GET" class="relative w-full md:w-96 group" id="searchForm">
                        @if(request('sppg_id'))
                            <input type="hidden" name="sppg_id" value="{{ request('sppg_id') }}">
                        @endif
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-gold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" id="materialSearch" 
                            value="{{ request('search') }}"
                            autofocus
                            onfocus="var val=this.value; this.value=''; this.value=val;"
                            class="w-full pl-12 pr-4 py-4 bg-white border-2 border-gold/5 rounded-2xl text-xs font-bold text-royal-navy placeholder-gray-400 focus:border-gold focus:ring-4 focus:ring-gold/10 outline-none transition-all shadow-xl shadow-royal-navy/5" 
                            placeholder="Cari bahan baku (ketik & Enter)...">
                    </form>
                </div>
            </div>

            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gold/10 relative">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-100" id="materialsTable">
                        <thead>
                            <tr class="bg-silk/50 border-b border-gray-100">
                                <th class="px-8 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Nama Bahan</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Kategori</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Stok</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Harga / Unit</th>
                                <th class="px-8 py-4 text-right text-[10px] font-black text-royal-navy uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($materials as $material)
                            <tr class="hover:bg-silk/30 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="font-bold text-royal-navy">{{ $material->name }}</div>
                                    @if($material->expiry_date)
                                        <div class="text-[10px] text-red-500 font-black uppercase tracking-widest mt-1">Exp: {{ \Carbon\Carbon::parse($material->expiry_date)->format('d M Y') }}</div>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-gold/10 text-gold text-[10px] font-black rounded-full uppercase tracking-widest">
                                        {{ $material->category }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="inline-flex items-center px-4 py-2 bg-royal-navy/5 text-royal-navy rounded-xl text-xs font-black">
                                        {{ number_format($material->stock, 2) }} {{ $material->unit }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-xs font-bold text-royal-navy">Rp {{ number_format($material->price, 0, ',', '.') }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">per {{ $material->unit }}</div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('material_logs.create', ['material_name' => $material->name, 'type' => 'out']) }}" class="p-2 text-gold hover:text-gold-dark transition-colors" title="Kurangi Stok">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </a>
                                        <a href="{{ route('materials.edit', $material) }}" class="p-2 text-royal-navy hover:text-gold transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Hapus bahan baku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-400 hover:text-red-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
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
    <script>
        $(document).ready(function() {
            let timeout = null;
            $("#materialSearch").on("keyup", function(e) {
                // Auto-submit after 800ms of inactivity or immediately on Enter
                clearTimeout(timeout);
                if (e.keyCode === 13) {
                    $("#searchForm").submit();
                } else {
                    timeout = setTimeout(function() {
                        $("#searchForm").submit();
                    }, 800);
                }
            });
        });
    </script>
</x-app-layout>
