<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('dishes.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Tambah Hidangan') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Daftarkan Menu Hidangan Baru ke Dalam Sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ route('dishes.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Hidangan</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold focus:ring-4 focus:ring-gold/10 transition-all outline-none"
                                    placeholder="Contoh: Nasi Goreng Spesial">
                                @error('name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Deskripsi Hidangan (Opsional)</label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold focus:ring-4 focus:ring-gold/10 transition-all outline-none"
                                    placeholder="Penjelasan singkat mengenai hidangan">{{ old('description') }}</textarea>
                                @error('description') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="youtube_url" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">
                                    🎬 Link YouTube Shorts (Opsional)
                                </label>
                                <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url') }}"
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold focus:ring-4 focus:ring-gold/10 transition-all outline-none"
                                    placeholder="https://www.youtube.com/watch?v=...">
                                <p class="mt-1 text-[10px] text-gray-400 uppercase tracking-widest">Paste link video YouTube / Shorts untuk ditampilkan di halaman publik</p>
                                @error('youtube_url') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    Daftarkan Hidangan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
