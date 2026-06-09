<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('assets.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Edit Aset') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Ubah data aset yang sudah terdaftar</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ route('assets.update', $asset) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="code" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Kode Aset *</label>
                                    <input type="text" name="code" id="code" value="{{ old('code', $asset->code) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('code') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Aset *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="qty" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Jumlah (Qty) *</label>
                                    <input type="number" name="qty" id="qty" value="{{ old('qty', $asset->qty) }}" required min="1"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('qty') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="sppg_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Unit SPPG</label>
                                    @if($user->sppg_id)
                                        <input type="hidden" name="sppg_id" value="{{ $user->sppg_id }}">
                                        <input type="text" readonly value="{{ $user->sppg->name }}" 
                                            class="w-full px-6 py-4 bg-silk/60 border-2 border-transparent rounded-2xl text-sm font-bold text-slate-500 cursor-not-allowed outline-none">
                                    @else
                                        <select id="sppg_id" name="sppg_id" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                            <option value="">-- Master / Global (Kantor Pusat) --</option>
                                            @foreach($sppgs as $sppg)
                                                <option value="{{ $sppg->id }}" {{ old('sppg_id', $asset->sppg_id) == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('sppg_id') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Deskripsi Aset</label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none resize-none">{{ old('description', $asset->description) }}</textarea>
                                @error('description') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    Perbarui Aset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
