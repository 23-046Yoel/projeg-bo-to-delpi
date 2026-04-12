<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="font-black text-4xl text-royal-navy leading-tight tracking-tighter uppercase font-playfair">
                    {{ __('Manajemen Staff') }}
                </h2>
                <div class="flex items-center mt-2 space-x-3">
                    <span class="w-8 h-[2px] bg-gold"></span>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Pengaturan Peran & Penugasan SPPG</p>
                </div>
            </div>
            <a href="{{ route('users.create') }}" class="px-8 py-4 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-royal-navy/10 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                Tambah Staff Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-sm font-bold flex items-center shadow-sm animate-fade-in uppercase tracking-widest">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white/40 backdrop-blur-xl rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.04)] border border-white/60 overflow-hidden">
                <div class="p-10">
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Nama / WA / Email</th>
                                    <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Peran (Role)</th>
                                    <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Lokasi SPPG</th>
                                    <th class="px-6 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($users as $user)
                                    <tr class="group hover:bg-gold/5 transition-all duration-300">
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-2xl bg-royal-navy flex items-center justify-center text-gold font-black text-sm shadow-lg group-hover:scale-110 transition-transform">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-black text-royal-navy uppercase tracking-tight">{{ $user->name }}</div>
                                                    <div class="text-[11px] text-emerald-600 font-bold">📲 +{{ $user->phone }}</div>
                                                    <div class="text-[10px] text-gray-400 font-medium italic">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <span class="inline-flex px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ 
                                                $user->role === 'admin' ? 'bg-royal-navy text-gold' : 
                                                ($user->role === 'volunteer' ? 'bg-emerald-50 text-emerald-600' : 'bg-silk text-gray-500') 
                                            }} shadow-sm border border-black/5">
                                                {{ $user->role_title }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            @if($user->sppg)
                                                <div class="flex items-center text-sm font-bold text-royal-navy">
                                                    <svg class="w-4 h-4 mr-2 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    {{ $user->sppg->name }}
                                                </div>
                                            @else
                                                <span class="text-[10px] font-black text-gray-300 uppercase italic">Belum Ditugaskan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('users.edit', $user) }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400 hover:text-royal-navy hover:bg-gold/10 hover:border-gold/20 transition-all duration-300 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 hover:border-red-100 transition-all duration-300 shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center">
                                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Tidak ada data staff ditemukan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
