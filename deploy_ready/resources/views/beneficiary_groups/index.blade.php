<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="font-black text-4xl text-royal-navy leading-tight tracking-tighter uppercase font-playfair">
                    {{ __('Manajemen Sekolah') }}
                </h2>
                <div class="flex items-center mt-2 space-x-3">
                    <span class="w-8 h-[2px] bg-gold"></span>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Induk Kelompok & Lokasi Distribusi</p>
                </div>
            </div>
            <a href="{{ route('beneficiary-groups.create') }}" class="group relative px-10 py-4 bg-royal-navy rounded-[1.5rem] font-black text-[10px] text-gold uppercase tracking-[0.25em] shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Tambah Sekolah Baru
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-10 p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center text-emerald-600 text-sm font-bold shadow-sm animate-fade-in">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white mr-4 shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white/40 backdrop-blur-xl rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.04)] border border-white/60 overflow-hidden">
                <div class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($groups as $group)
                            <div class="group relative bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-[0_40px_60px_rgba(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-500">
                                <!-- School Icon/Badge -->
                                <div class="flex justify-between items-start mb-8">
                                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-royal-navy to-royal-navy/80 shadow-2xl shadow-royal-navy/20 flex items-center justify-center text-gold group-hover:rotate-12 transition-transform duration-500">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('beneficiary-groups.edit', $group) }}" class="w-10 h-10 rounded-xl bg-silk border border-gray-50 flex items-center justify-center text-gray-400 hover:text-royal-navy hover:bg-gold/10 hover:border-gold/20 transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('beneficiary-groups.destroy', $group) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus sekolah ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-silk border border-gray-50 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 hover:border-red-100 transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- School Info -->
                                <div class="mb-8">
                                    <h3 class="text-xl font-black text-royal-navy tracking-tight group-hover:text-gold-dark transition-colors duration-300 uppercase">{{ $group->name }}</h3>
                                    <div class="flex items-center mt-3 text-gray-400">
                                        <svg class="w-4 h-4 mr-2 text-gold/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <p class="text-xs font-bold italic line-clamp-1">{{ $group->location ?? 'Lokasi belum diatur' }}</p>
                                    </div>
                                </div>

                                <!-- Stats & ID -->
                                <div class="pt-8 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em]">Estimasi</span>
                                        <span class="text-sm font-black text-royal-navy">{{ $group->total_beneficiaries ?? '0' }} <span class="text-[10px] text-gold-dark font-black">JIWA</span></span>
                                    </div>
                                    <div class="text-[9px] font-black text-gray-300 uppercase tracking-widest bg-silk px-3 py-1.5 rounded-lg border border-gray-50">
                                        #SCH-{{ str_pad($group->id, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-24 text-center">
                                <div class="w-24 h-24 bg-silk rounded-full flex items-center justify-center mx-auto mb-6 opacity-50">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <h3 class="font-black text-royal-navy uppercase tracking-widest">Belum Ada Sekolah</h3>
                                <p class="text-xs text-gray-400 font-bold mt-2">Daftarkan sekolah induk untuk memulai manajemen penerima manfaat.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12">
                        {{ $groups->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
