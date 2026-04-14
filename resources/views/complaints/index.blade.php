<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Layanan Pengaduan') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Manajemen Laporan & Aduan Publik</p>
            </div>
            <div class="flex items-center space-x-2 text-[10px] font-bold text-gray-300 tracking-widest uppercase">
                <span>Operational</span>
                <span class="text-gold">/</span>
                <span class="text-royal-navy">Complaints</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="premium-card p-6 flex items-center space-x-4 border-l-4 border-yellow-400">
                    <div class="w-12 h-12 rounded-2xl bg-yellow-50 flex items-center justify-center text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Menunggu</p>
                        <p class="text-2xl font-black text-royal-navy mt-0.5">{{ \App\Models\Complaint::where('status', 'Menunggu')->count() }}</p>
                    </div>
                </div>
                <div class="premium-card p-6 flex items-center space-x-4 border-l-4 border-blue-500">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Diproses</p>
                        <p class="text-2xl font-black text-royal-navy mt-0.5">{{ \App\Models\Complaint::where('status', 'Diproses')->count() }}</p>
                    </div>
                </div>
                <div class="premium-card p-6 flex items-center space-x-4 border-l-4 border-emerald-500">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Selesai</p>
                        <p class="text-2xl font-black text-royal-navy mt-0.5">{{ \App\Models\Complaint::where('status', 'Selesai')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gold/10 relative">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-royal-navy">
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold uppercase tracking-[0.2em]">Pelapor & Info</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold uppercase tracking-[0.2em]">Kategori</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold uppercase tracking-[0.2em]">Deskripsi</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold uppercase tracking-[0.2em]">Foto</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold uppercase tracking-[0.2em]">Status</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-gold uppercase tracking-[0.2em]">Update</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 bg-white/30">
                            @forelse($complaints as $complaint)
                            <tr class="hover:bg-gold/5 transition-all duration-300 group">
                                <td class="px-8 py-6">
                                    <div class="font-black text-royal-navy tracking-tight uppercase text-sm">{{ $complaint->name }}</div>
                                    <div class="text-[11px] font-bold text-gold-dark mt-1">{{ $complaint->phone }}</div>
                                    <div class="text-[9px] text-gray-400 mt-1 uppercase tracking-widest">{{ $complaint->created_at->format('d M Y - H:i') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-block px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100">
                                        {{ $complaint->type }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-xs text-slate-500 font-medium leading-relaxed max-w-xs">{{ Str::limit($complaint->description, 100) }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    @if($complaint->photo_path)
                                        <a href="{{ asset('storage/' . $complaint->photo_path) }}" target="_blank" class="w-10 h-10 rounded-xl bg-royal-navy flex items-center justify-center text-gold shadow-lg hover:scale-110 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-300 italic">No File</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                        @if($complaint->status == 'Menunggu') bg-yellow-50 text-yellow-600 border border-yellow-100
                                        @elseif($complaint->status == 'Diproses') bg-blue-50 text-blue-600 border border-blue-100
                                        @else bg-emerald-50 text-emerald-600 border border-emerald-100 @endif
                                    ">
                                        {{ $complaint->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($complaint->status == 'Menunggu')
                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Diproses">
                                                <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                                                    Proses
                                                </button>
                                            </form>
                                        @endif

                                        @if($complaint->status != 'Selesai')
                                            <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="Selesai">
                                                <button type="submit" class="px-3 py-1 bg-emerald-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">
                                                    Selesaikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest italic">Tuntas</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-200 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-400 italic">Belum ada aduan masuk untuk saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($complaints->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                    {{ $complaints->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
