<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="font-black text-4xl text-royal-navy leading-tight tracking-tighter uppercase font-playfair">
                    {{ __('Daftar Hidangan') }}
                </h2>
                <div class="flex items-center mt-2 space-x-3">
                    <span class="w-8 h-[2px] bg-gold"></span>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Master Standar Resep & Komposisi</p>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <form action="{{ route('dishes.index') }}" method="GET" class="relative group" id="dishSearchForm">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-gold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" id="dishSearch" 
                        value="{{ request('search') }}"
                        autofocus
                        onfocus="var val=this.value; this.value=''; this.value=val;"
                        class="w-64 pl-12 pr-4 py-3 bg-white border-2 border-gold/5 rounded-2xl text-[10px] font-bold text-royal-navy placeholder-gray-400 focus:border-gold focus:ring-4 focus:ring-gold/10 outline-none transition-all shadow-xl shadow-royal-navy/5" 
                        placeholder="Cari Hidangan...">
                </form>
                <a href="{{ route('dishes.create') }}" class="group relative px-10 py-4 bg-royal-navy rounded-[1.5rem] font-black text-[10px] text-gold uppercase tracking-[0.25em] shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Tambah Hidangan Baru
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/40 backdrop-blur-xl rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.04)] border border-white/60 overflow-hidden">
                <div class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($dishes as $dish)
                            <div class="group relative bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-[0_40px_60px_rgba(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-500">
                                <!-- Dish Icon/Initial -->
                                <div class="flex justify-between items-start mb-8">
                                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-royal-navy to-royal-navy/80 shadow-2xl shadow-royal-navy/20 flex items-center justify-center text-gold group-hover:rotate-12 transition-transform duration-500">
                                        <span class="font-black text-2xl font-playfair">{{ substr($dish->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('dishes.edit', $dish) }}" class="w-10 h-10 rounded-xl bg-silk border border-gray-50 flex items-center justify-center text-gray-400 hover:text-royal-navy hover:bg-gold/10 hover:border-gold/20 transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('dishes.destroy', $dish) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus hidangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-xl bg-silk border border-gray-50 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 hover:border-red-100 transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Dish Info -->
                                <div class="mb-8">
                                    <h3 class="text-xl font-black text-royal-navy tracking-tight group-hover:text-gold-dark transition-colors duration-300">{{ $dish->name }}</h3>
                                    <p class="text-xs text-gray-400 font-bold mt-2 h-10 line-clamp-2 italic leading-relaxed">{{ $dish->description ?? 'Tidak ada deskripsi untuk hidangan ini.' }}</p>
                                </div>

                                <!-- Stats & Action -->
                                <div class="pt-8 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em]">Komposisi</span>
                                        <span class="text-sm font-black text-royal-navy">{{ $dish->recipes_count }} <span class="text-[10px] text-gold-dark">Bahan</span></span>
                                    </div>
                                    <a href="{{ route('dishes.show', $dish) }}" class="inline-flex items-center px-6 py-3 bg-silk rounded-2xl text-[10px] font-black uppercase tracking-widest text-royal-navy hover:bg-royal-navy hover:text-gold transition-all duration-500 shadow-sm">
                                        Kelola Resep
                                        <svg class="w-3 h-3 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center">
                                <div class="w-24 h-24 bg-silk rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                </div>
                                <h3 class="font-black text-royal-navy uppercase tracking-widest">Belum Ada Menu</h3>
                                <p class="text-xs text-gray-400 font-bold mt-2">Mulai tambahkan hidangan baru untuk menyusun resep.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12 px-2">
                        {{ $dishes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    <script>
        $(document).ready(function() {
            let dishTimeout = null;
            $("#dishSearch").on("keyup", function(e) {
                clearTimeout(dishTimeout);
                if (e.keyCode === 13) {
                    $("#dishSearchForm").submit();
                } else {
                    dishTimeout = setTimeout(function() {
                        $("#dishSearchForm").submit();
                    }, 800);
                }
            });
        });
    </script>
