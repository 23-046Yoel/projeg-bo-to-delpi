<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-6">
            <a href="{{ route('dishes.show', $recipe->dish_id) }}" class="w-16 h-16 rounded-[2rem] bg-white border-2 border-gray-100 shadow-xl flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all duration-500 transform hover:-translate-x-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-4xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ $recipe->material->name }}
                </h2>
                <p class="text-xs font-black text-gold-dark uppercase tracking-[0.4em] mt-2">Update Gramasi & Komposisi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 min-h-screen bg-silk/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[4rem] shadow-[0_50px_100px_rgba(0,0,0,0.06)] border-4 border-white overflow-hidden relative">
                <div class="absolute top-0 right-0 w-80 h-80 bg-gold/5 rounded-full -mr-40 -mt-40"></div>
                
                <div class="p-10 md:p-20 relative z-10">
                    <form action="{{ route('recipes.update', $recipe) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-16">
                            <!-- Mega Input Gramasi -->
                            <div class="text-center">
                                <label class="block text-2xl font-black text-royal-navy uppercase tracking-[0.3em] mb-10">JUMLAH / GRAMASI :</label>
                                <div class="relative">
                                    <input type="number" step="0.0001" name="quantity" value="{{ $recipe->quantity }}" required
                                        class="w-full px-12 py-14 bg-silk/50 border-8 border-gold/30 rounded-[4rem] text-8xl font-black text-royal-navy focus:bg-white focus:border-gold outline-none transition-all shadow-2xl text-center tracking-tighter">
                                    <div class="mt-6 text-gold-dark font-black text-xl tracking-[0.5em] uppercase">ANGKA PRESISI</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                <!-- Mega Input Satuan -->
                                <div>
                                    <label class="block text-lg font-black text-gray-400 uppercase tracking-widest mb-6 ml-4">SATUAN :</label>
                                    <input type="text" name="unit" value="{{ $recipe->unit }}" required
                                        class="w-full px-10 py-10 bg-silk/50 border-4 border-transparent rounded-[3rem] text-4xl font-black text-royal-navy focus:bg-white focus:border-gold outline-none transition-all shadow-inner uppercase text-center"
                                        placeholder="GR / ML / PCS">
                                </div>

                                <!-- Mega Input Catatan -->
                                <div>
                                    <label class="block text-lg font-black text-gray-400 uppercase tracking-widest mb-6 ml-4">CATATAN :</label>
                                    <textarea name="notes" rows="2"
                                        class="w-full px-10 py-8 bg-silk/50 border-4 border-transparent rounded-[3rem] text-2xl font-black text-royal-navy focus:bg-white focus:border-gold outline-none transition-all shadow-inner"
                                        placeholder="Tambahkan catatan khusus jika ada...">{{ $recipe->notes }}</textarea>
                                </div>
                            </div>

                            <div class="pt-10 space-y-6">
                                <button type="submit" class="w-full py-12 bg-gold text-royal-navy font-black text-3xl uppercase tracking-[0.4em] rounded-[3rem] shadow-[0_30px_60px_rgba(212,175,55,0.4)] hover:bg-gold-dark hover:-translate-y-2 transition-all active:scale-95 flex items-center justify-center gap-6">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    SIMPAN PERUBAHAN
                                </button>
                                
                                <a href="{{ route('dishes.show', $recipe->dish_id) }}" class="w-full py-8 border-4 border-gray-100 rounded-[3rem] text-gray-400 font-black text-xl uppercase tracking-[0.3em] flex items-center justify-center hover:bg-silk transition-all">
                                    BATAL & KEMBALI
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</x-app-layout>
