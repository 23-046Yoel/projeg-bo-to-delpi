<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('LPJ Harian SPPG') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Laporan Pertanggungjawaban Harian (MBG)</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('production.daily-lpj.create', ['date' => date('Y-m-d'), 'sppg_id' => auth()->user()->sppg_id]) }}" class="px-5 py-2 bg-royal-navy text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy/90 transition-all shadow-lg shadow-royal-navy/10 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat LPJ Hari Ini
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs font-bold uppercase tracking-widest rounded-r-xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-bold uppercase tracking-widest rounded-r-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="mb-8">
                <form action="{{ route('production.daily-lpj.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
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
                                    <th class="px-4 py-4 text-left text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Ringkasan Produksi</th>
                                    <th class="px-4 py-4 text-center text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk/30">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($lpjs as $lpj)
                                    <tr class="hover:bg-gold/5 transition-colors group">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <div class="text-[10px] font-black text-gold-dark uppercase tracking-widest mb-1">{{ $lpj->sppg->name }}</div>
                                                <div class="text-sm font-black text-royal-navy">{{ \Carbon\Carbon::parse($lpj->date)->translatedFormat('d M Y') }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-semibold text-gray-700">{{ $lpj->menu->karbo }}</div>
                                            <div class="text-[10px] text-gray-400">{{ $lpj->menu->dishes->pluck('name')->implode(', ') }}</div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-bold text-royal-navy">Dist: {{ $lpj->total_distribution }} PM</div>
                                            <div class="text-[9px] text-gray-400 uppercase font-bold">Exp: Rp {{ number_format($lpj->total_expenditure, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('production.daily-lpj.show', $lpj) }}" class="p-2 bg-silk border border-gray-100 rounded-lg text-royal-navy hover:bg-gray-100 transition-all" title="Lihat/Print">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                                <a href="{{ route('production.daily-lpj.edit', $lpj) }}" class="p-2 bg-gold/10 border border-gold/20 rounded-lg text-gold-dark hover:bg-gold/20 transition-all" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('production.daily-lpj.destroy', $lpj) }}" method="POST" onsubmit="return confirm('Hapus LPJ ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 bg-red-50 border border-red-100 rounded-lg text-red-600 hover:bg-red-100 transition-all" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-12 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada LPJ Harian yang dibuat</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $lpjs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <dialog id="createLpjModal" class="modal p-0 rounded-2xl shadow-2xl backdrop:bg-royal-navy/20">
        <div class="p-8 w-[400px]">
            <h3 class="text-lg font-black text-royal-navy uppercase tracking-widest mb-6">Buat LPJ Baru</h3>
            <form action="{{ route('production.daily-lpj.create') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih Dapur</label>
                    <select name="sppg_id" required class="w-full px-4 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-sm font-bold focus:border-gold outline-none transition-all">
                        @foreach($sppgs as $sppg)
                            <option value="{{ $sppg->id }}" {{ auth()->user()->sppg_id == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih Tanggal</label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-silk/30 border-2 border-transparent rounded-xl text-sm font-bold focus:border-gold outline-none transition-all">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('createLpjModal').close()" class="flex-1 px-4 py-3 bg-silk text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gray-100 transition-all">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-gold text-royal-navy text-[10px] font-black uppercase rounded-xl hover:bg-gold/80 transition-all shadow-lg shadow-gold/20">Lanjutkan</button>
                </div>
            </form>
        </div>
    </dialog>
</x-app-layout>
