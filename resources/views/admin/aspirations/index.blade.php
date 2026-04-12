<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">Moderasi Aspirasi</h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Kelola & Approve Pesan Aspirasi Masyarakat</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 font-bold text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="font-black text-royal-navy font-playfair uppercase text-lg">Semua Aspirasi</h3>
                    <span class="px-4 py-1.5 bg-royal-navy/5 text-royal-navy text-[10px] font-black rounded-full uppercase tracking-widest">{{ $aspirations->total() }} Total</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Aspirasi</th>
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pengirim</th>
                                <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($aspirations as $aspiration)
                            <tr class="hover:bg-slate-50/50 transition-colors {{ $aspiration->is_pinned ? 'bg-yellow-50/50' : '' }}">
                                <td class="px-8 py-5 max-w-md">
                                    <p class="text-sm text-royal-navy font-bold leading-relaxed">
                                        @if($aspiration->is_pinned) 📌 @endif
                                        {{ $aspiration->content }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ $aspiration->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="block text-sm font-black text-royal-navy">{{ $aspiration->sender_name }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $aspiration->location }}</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($aspiration->is_active)
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-full uppercase">✓ Aktif di Ticker</span>
                                    @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-black rounded-full uppercase">⏳ Menunggu Approve</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Toggle Active -->
                                        <form method="POST" action="{{ route('aspirations.toggle', $aspiration) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $aspiration->is_active ? 'bg-red-50 text-red-600 hover:bg-red-500 hover:text-white' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white' }}">
                                                {{ $aspiration->is_active ? 'Nonaktifkan' : 'Approve' }}
                                            </button>
                                        </form>
                                        <!-- Pin -->
                                        <form method="POST" action="{{ route('aspirations.pin', $aspiration) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-yellow-50 text-yellow-600 hover:bg-yellow-500 hover:text-white transition-all">
                                                {{ $aspiration->is_pinned ? 'Unpin' : 'Pin' }}
                                            </button>
                                        </form>
                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('aspirations.destroy', $aspiration) }}" onsubmit="return confirm('Hapus aspirasi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-8 py-16 text-center text-gray-400 font-bold">Belum ada aspirasi yang masuk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($aspirations->hasPages())
                <div class="p-8 border-t border-gray-50">{{ $aspirations->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
