<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                {{ __('Manajemen Berita') }}
            </h2>
            <a href="{{ route('news.create') }}" class="px-6 py-2 bg-gold text-royal-navy font-black text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-gold/20 hover:scale-105 transition-all">
                Tambah Berita
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100">
                <div class="p-0">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Gambar</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Judul / Dapur</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tgl Terbit</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($news as $item)
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-8 py-5">
                                    @if($item->image_path)
                                        <img src="{{ Storage::url($item->image_path) }}" class="w-16 h-16 object-cover rounded-xl shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-black text-royal-navy text-sm">{{ $item->title }}</div>
                                    <div class="text-[10px] text-gold font-bold uppercase tracking-widest">{{ $item->sppg->name ?? 'Update Umum' }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-xs text-gray-500 font-medium">{{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('news.edit', $item) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('news.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-gray-400 italic">Belum ada berita yang diterbitkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($news->hasPages())
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                    {{ $news->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
