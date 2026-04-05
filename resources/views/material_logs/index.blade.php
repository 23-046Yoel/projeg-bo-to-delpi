<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Input Stok') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Laporan Arus Bahan SPPG</p>
            </div>
            <a href="{{ route('material_logs.create') }}" class="group relative px-8 py-3 bg-gold rounded-2xl font-black text-xs text-royal-navy uppercase tracking-[0.2em] shadow-xl shadow-gold/20 hover:bg-gold/80 transition-all duration-300 transform hover:-translate-y-1">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Entry
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
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Timestamp</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Material</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Flow</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($logs as $log)
                                    <tr class="hover:bg-silk/50 transition-colors group">
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="text-sm font-bold text-royal-navy">{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</div>
                                            <div class="text-[10px] text-gray-300 font-bold uppercase tracking-widest mt-0.5">Ref: #ML-{{ str_pad($log->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-xl bg-royal-navy/5 flex items-center justify-center text-royal-navy mr-4 group-hover:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                </div>
                                                <span class="text-sm font-black text-royal-navy tracking-tight">{{ $log->material->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $log->type == 'in' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                                @if($log->type == 'in')
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                                    Masuk
                                                @else
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                                    Keluar
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-right">
                                            <div class="text-lg font-black font-playfair {{ $log->type == 'in' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                {{ $log->type == 'in' ? '+' : '-' }} {{ number_format($log->quantity, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('material_logs.edit', $log) }}" class="p-2 text-gray-400 hover:text-gold transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('material_logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data ini? Stok akan otomatis disesuaikan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 px-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
