<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-xs font-bold text-gold-dark uppercase tracking-[0.3em] mb-1">Administration</span>
            <h2 class="text-3xl font-playfair font-black text-royal-navy italic leading-tight">
                Daftar Pendaftar Konsultasi Gizi
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- Header Actions --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-sm text-slate-500 mt-1">Total: <span class="font-black text-gold-dark">{{ $consultations->total() }}</span> pendaftar</p>
            </div>
            <a href="{{ route('nutrition.consultation') }}" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-royal-navy text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-gold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Form Publik
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-royal-navy text-white text-xs uppercase tracking-widest">
                            <th class="px-6 py-4 text-left font-black">#</th>
                            <th class="px-6 py-4 text-left font-black">Nama</th>
                            <th class="px-6 py-4 text-left font-black">No. HP</th>
                            <th class="px-6 py-4 text-left font-black">Usia</th>
                            <th class="px-6 py-4 text-left font-black">Gender</th>
                            <th class="px-6 py-4 text-left font-black">BB/TB</th>
                            <th class="px-6 py-4 text-left font-black">Tujuan</th>
                            <th class="px-6 py-4 text-left font-black">Riwayat Medis</th>
                            <th class="px-6 py-4 text-left font-black">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($consultations as $i => $c)
                        <tr class="hover:bg-gold/5 transition-colors group">
                            <td class="px-6 py-4 font-black text-slate-400 text-xs">{{ $consultations->firstItem() + $i }}</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-royal-navy">{{ $c->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                @if($c->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->phone) }}" target="_blank"
                                       class="text-emerald-600 font-bold hover:underline">{{ $c->phone }}</a>
                                @else
                                    <span class="text-slate-300 italic text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-bold">{{ $c->age }} th</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                    {{ $c->gender === 'Laki-laki' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                    {{ $c->gender }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-xs font-bold">{{ $c->weight }} kg / {{ $c->height }} cm</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-gold/10 text-gold-dark text-[10px] font-black uppercase tracking-widest">
                                    {{ $c->goal }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs max-w-[180px] truncate">
                                {{ $c->medical_history ?: '—' }}
                            </td>
                            <td class="px-6 py-4 text-slate-400 text-xs font-bold">
                                {{ $c->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <p class="text-slate-400 font-bold">Belum ada pendaftar konsultasi gizi.</p>
                                    <a href="{{ route('nutrition.consultation') }}" class="text-xs font-black text-gold uppercase tracking-widest hover:underline">Bagikan link form pendaftaran ↗</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($consultations->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $consultations->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
