<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-playfair font-black text-3xl text-royal-navy leading-tight tracking-tight">
                    {{ __('Manajemen Aset') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">Daftar dan catat aset inventaris untuk tiap unit kerja SPPG.</p>
            </div>
            <div>
                <a href="{{ route('assets.create') }}" class="btn-premium">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Aset Baru</span>
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-3xl flex items-center gap-4 animate-fade-in">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gold/10 relative">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-royal-navy">
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Kode Aset</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Nama Aset</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Jumlah (Qty)</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Unit SPPG</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Deskripsi</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 bg-white/30">
                            @forelse ($assets as $asset)
                                <tr class="hover:bg-gold/5 transition-all duration-300 group">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-lg bg-silk text-xs font-black text-royal-navy border border-gold/10 uppercase tracking-wider">
                                            {{ $asset->code }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-sm font-black text-royal-navy">{{ $asset->name }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-sm font-bold text-slate-700">{{ $asset->qty }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        @if($asset->sppg)
                                            <span class="px-2.5 py-1 rounded-full bg-gold/10 text-gold-dark text-[10px] font-black uppercase tracking-wider border border-gold/20">
                                                {{ $asset->sppg->name }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                                                Master / Global
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-xs text-slate-500 font-bold block max-w-xs truncate">{{ $asset->description ?? '-' }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right text-xs font-bold space-x-2">
                                        <a href="{{ route('assets.edit', $asset) }}" class="inline-flex items-center px-3 py-1.5 bg-silk hover:bg-gold/20 text-royal-navy hover:text-gold-dark border border-gold/10 rounded-xl transition-all">
                                            Edit
                                        </a>
                                        <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-16 text-center">
                                        <div class="w-16 h-16 rounded-2xl bg-silk border border-gold/10 flex items-center justify-center mx-auto mb-4 text-gold-dark">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <h4 class="font-black text-royal-navy uppercase tracking-widest text-sm mb-1">Belum ada aset terdaftar</h4>
                                        <p class="text-xs font-bold text-slate-400">Silakan tambahkan aset inventaris baru Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-400 tracking-wide uppercase">
                        Showing <span class="text-royal-navy">{{ $assets->firstItem() ?? 0 }}</span> to <span class="text-royal-navy">{{ $assets->lastItem() ?? 0 }}</span> of <span class="text-royal-navy">{{ $assets->total() }}</span> assets
                    </p>
                    <div class="premium-pagination">
                        {{ $assets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
