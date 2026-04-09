<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="font-black text-4xl text-royal-navy leading-tight tracking-tighter uppercase font-playfair">
                    Manajemen Penerima Manfaat
                </h2>
                <div class="flex items-center mt-2 space-x-3">
                    <span class="w-8 h-[2px] bg-gold"></span>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Sekolah & Posyandu — Seluruh SPPG</p>
                </div>
            </div>
            <a href="{{ route('beneficiary-groups.create') }}" class="group relative px-10 py-4 bg-royal-navy rounded-[1.5rem] font-black text-[10px] text-gold uppercase tracking-[0.25em] shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Tambah Penerima Baru
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-10 p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center text-emerald-600 text-sm font-bold shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter Section --}}
            @if(auth()->user()->role === 'admin')
                <div class="mb-10 p-8 bg-white/60 backdrop-blur-md rounded-[2.5rem] border border-white shadow-sm">
                    <form action="{{ route('beneficiary-groups.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-6">
                        <div class="flex-1 w-full uppercase">
                            <label for="sppg_id" class="block text-[10px] font-black text-slate-400 tracking-[0.2em] mb-3 ml-1">Filter Berdasarkan Dapur (SPPG)</label>
                            <select name="sppg_id" id="sppg_id" class="w-full bg-white border-slate-100 rounded-2xl py-3.5 px-6 text-sm font-bold text-royal-navy focus:ring-gold focus:border-gold transition-all shadow-sm">
                                <option value="">Semua Dapur</option>
                                @foreach($sppgs ?? [] as $s)
                                    <option value="{{ $s->id }}" {{ request('sppg_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <button type="submit" class="flex-1 md:flex-none px-8 py-4 bg-royal-navy rounded-2xl font-black text-[10px] text-gold uppercase tracking-[0.2em] shadow-xl shadow-royal-navy/10 hover:scale-105 transition-all">Terapkan</button>
                            <a href="{{ route('beneficiary-groups.index') }}" class="flex-1 md:flex-none px-8 py-4 bg-white border border-slate-100 rounded-2xl font-black text-[10px] text-slate-400 uppercase tracking-[0.2em] hover:bg-slate-50 transition-all text-center">Reset</a>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Summary Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm text-center">
                    <div class="text-2xl font-black text-royal-navy">{{ $groups->sum('count_siswa') }}</div>
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Siswa</div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm text-center">
                    <div class="text-2xl font-black text-gold-dark">{{ $groups->sum('count_guru') }}</div>
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Guru & Staff</div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm text-center">
                    <div class="text-2xl font-black text-emerald-600">{{ $groups->sum('count_hamil') + $groups->sum('count_menyusui') }}</div>
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Ibu Hamil/Menyusui</div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm text-center">
                    <div class="text-2xl font-black text-rose-600">{{ $groups->sum('count_balita') }}</div>
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Balita</div>
                </div>
                <div class="bg-royal-navy rounded-[2rem] p-6 text-white text-center shadow-xl shadow-royal-navy/20">
                    <div class="text-2xl font-black text-gold">{{ number_format($groups->sum('total_beneficiaries')) }}</div>
                    <div class="text-[9px] font-black text-white/60 uppercase tracking-widest mt-1">Total Penerima</div>
                </div>
            </div>

            <div class="bg-white/40 backdrop-blur-xl rounded-[3rem] shadow-sm border border-white/60 overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($groups as $group)
                            <div class="group relative bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-[0_15px_40px_rgba(0,0,0,0.03)] hover:shadow-[0_50px_80px_rgba(15,23,42,0.12)] hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                                
                                {{-- Background Glow Decor --}}
                                <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full blur-[60px] opacity-10 transition-opacity group-hover:opacity-20
                                    {{ ($group->type ?? 'sekolah') === 'posyandu' ? 'bg-pink-500' : 'bg-royal-navy' }}"></div>

                                {{-- Header UI --}}
                                <div class="flex justify-between items-start mb-8 relative z-10">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white shadow-2xl transition-all duration-500 group-hover:rotate-6
                                            {{ ($group->type ?? 'sekolah') === 'posyandu' ? 'bg-gradient-to-br from-pink-500 to-rose-600 shadow-pink-500/30' : 'bg-gradient-to-br from-royal-navy to-slate-800 shadow-royal-navy/30' }}">
                                            @if(($group->type ?? 'sekolah') === 'posyandu')
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                            @else
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-6"/></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-[9px] font-black uppercase tracking-[0.25em] px-3 py-1.5 rounded-xl border
                                                {{ ($group->type ?? 'sekolah') === 'posyandu' ? 'bg-rose-50 border-rose-100 text-rose-600' : 'bg-blue-50 border-blue-100 text-royal-navy' }}">
                                                {{ ucfirst($group->type ?? 'Sekolah') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('beneficiary-groups.edit', $group) }}" class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:text-royal-navy hover:bg-white hover:shadow-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('beneficiary-groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Hapus penerima ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-white hover:shadow-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- School Name & SPPG --}}
                                <div class="mb-6 relative z-10">
                                    <h3 class="text-xl font-black text-royal-navy leading-tight mb-2 uppercase group-hover:text-gold-dark transition-colors">{{ $group->name }}</h3>
                                    @if($group->sppg)
                                        <p class="text-[10px] font-black text-gold uppercase tracking-[0.2em] mb-3">{{ $group->sppg->name }}</p>
                                    @endif
                                    <div class="flex items-start text-slate-400 gap-2">
                                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        <p class="text-xs font-bold leading-relaxed italic">{{ $group->location ?? 'Lokasi belum diatur' }}</p>
                                    </div>
                                </div>

                                {{-- Main Population Data - Perfect match to PDF --}}
                                <div class="bg-slate-50 rounded-[2rem] p-6 mb-4 relative z-10 border border-slate-100">
                                    <div class="grid grid-cols-2 gap-4">
                                        @if(($group->type ?? 'sekolah') === 'sekolah')
                                            <div>
                                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Jumlah Siswa</div>
                                                <div class="text-2xl font-black text-royal-navy">{{ $group->count_siswa }}</div>
                                            </div>
                                            <div class="border-l border-slate-200 pl-4">
                                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Guru & Staff</div>
                                                <div class="text-2xl font-black text-royal-navy">{{ $group->count_guru }}</div>
                                            </div>
                                        @else
                                            <div class="col-span-2 grid grid-cols-3 gap-2">
                                                <div>
                                                    <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Ibu Hamil</div>
                                                    <div class="text-xl font-black text-rose-600">{{ $group->count_hamil }}</div>
                                                </div>
                                                <div class="border-x border-slate-200 px-3 text-center">
                                                    <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Ibu Menyusui</div>
                                                    <div class="text-xl font-black text-rose-600">{{ $group->count_menyusui }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Balita</div>
                                                    <div class="text-xl font-black text-rose-600">{{ $group->count_balita }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Final Total --}}
                                <div class="flex items-center justify-between pt-4 border-t border-slate-100 relative z-10">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Grand Total</span>
                                        <div class="h-1.5 w-1.5 rounded-full bg-gold"></div>
                                    </div>
                                    <div class="px-5 py-2 rounded-2xl bg-royal-navy text-gold text-lg font-black italic shadow-xl shadow-royal-navy/20">
                                        {{ $group->total_beneficiaries }} <span class="text-[10px] uppercase ml-1">Jiwa</span>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="col-span-full py-24 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 opacity-50">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <h3 class="font-black text-royal-navy uppercase tracking-widest">Belum Ada Penerima Manfaat</h3>
                                <p class="text-xs text-gray-400 font-bold mt-2">Klik tombol "Tambah Penerima Baru" di kanan atas.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10">
                        {{ $groups->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
