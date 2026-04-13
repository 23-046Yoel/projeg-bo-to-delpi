<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                {{ __('Terbitkan Berita Baru') }}
            </h2>
            <a href="{{ route('news.index') }}" class="text-xs font-black text-gray-400 hover:text-gold uppercase tracking-widest transition-colors">
                &lsaquo; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 sm:p-12 shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                @csrf
                
                <div class="space-y-8">
                    <!-- Title -->
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Judul Berita *</label>
                        <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Penyerahan Bahan Baku Segar di Dapur SPPG..." class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl text-royal-navy font-bold placeholder-gray-300 focus:ring-2 focus:ring-gold transition-all">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid sm:grid-cols-2 gap-8">
                        <!-- Dapur Selection -->
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Unit Dapur (Opsional)</label>
                            <select name="sppg_id" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl text-royal-navy font-bold focus:ring-2 focus:ring-gold transition-all">
                                <option value="">Update Umum Sistem</option>
                                @foreach($sppgs as $sppg)
                                    <option value="{{ $sppg->id }}" {{ old('sppg_id') == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Published Date -->
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Tanggal Publikasi</label>
                            <input type="date" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl text-royal-navy font-bold focus:ring-2 focus:ring-gold transition-all">
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Foto Dokumentasi (Max 2MB)</label>
                        <div class="relative group">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="p-8 border-2 border-dashed border-gray-200 rounded-[2rem] text-center group-hover:border-gold group-hover:bg-gold/5 transition-all">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3 group-hover:text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs font-bold text-gray-400 group-hover:text-royal-navy">Klik atau seret foto ke sini</p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Isi Berita *</label>
                        <textarea name="content" required rows="6" placeholder="Ceritakan detail aksi nyata atau berita transparan dapur..." class="w-full px-6 py-4 bg-gray-50 border-none rounded-[2rem] text-royal-navy font-medium placeholder-gray-300 focus:ring-2 focus:ring-gold transition-all resize-none">{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:scale-[1.02] transition-all">
                            Terbitkan Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
