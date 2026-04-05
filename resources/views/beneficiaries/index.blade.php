<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-playfair font-black text-3xl text-royal-navy leading-tight tracking-tight">
                    {{ __('Daftar Penerima Manfaat') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">Kelola data anak dan pemantauan tumbuh kembang.</p>
            </div>
            <a href="{{ route('beneficiaries.create') }}" class="btn-premium scale-90 md:scale-100">
                <span class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Penerima</span>
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gold/10 relative">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="border-b border-gray-50">
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Nama Anak</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kategori</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Asal Sekolah</th>
                                <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Data Fisik</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($beneficiaries as $beneficiary)
                                <tr class="hover:bg-silk/50 transition-colors group">
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-royal-navy/5 flex items-center justify-center text-royal-navy font-bold mr-4">
                                                {{ substr($beneficiary->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-royal-navy">{{ $beneficiary->name }}</div>
                                                <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Umur: {{ $beneficiary->age }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-gold/10 text-gold-dark rounded-lg text-[10px] font-black uppercase tracking-wider">
                                            {{ $beneficiary->category ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-600">{{ $beneficiary->group->name ?? $beneficiary->origin ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <div class="text-[10px] font-black text-royal-navy uppercase">
                                            {{ $beneficiary->height ?? '-' }} cm / {{ $beneficiary->weight ?? '-' }} kg
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right">
                                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-silk border border-gold/10 text-gold-dark hover:bg-royal-navy hover:text-gold transition-all duration-300 shadow-sm active:scale-90">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 text-xs font-bold uppercase tracking-widest italic">Belum ada data penerima</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-400 tracking-wide uppercase">
                        Terdaftar <span class="text-royal-navy">{{ $beneficiaries->total() }}</span> Penerima
                    </p>
                    <div class="premium-pagination">
                        {{ $beneficiaries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
