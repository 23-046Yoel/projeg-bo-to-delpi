<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('materials.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Edit Bahan Baku') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Perbarui Detail Bahan Baku</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ route('materials.update', $material) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="col-span-1 md:col-span-2">
                                    <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Bahan Baku</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $material->name) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                </div>

                                <div>
                                    <label for="category" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Kategori</label>
                                    <select id="category" name="category" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <option value="Karbohidrat" {{ $material->category == 'Karbohidrat' ? 'selected' : '' }}>Karbohidrat</option>
                                        <option value="Protein Hewani" {{ $material->category == 'Protein Hewani' ? 'selected' : '' }}>Protein Hewani</option>
                                        <option value="Protein Nabati" {{ $material->category == 'Protein Nabati' ? 'selected' : '' }}>Protein Nabati</option>
                                        <option value="Buah" {{ $material->category == 'Buah' ? 'selected' : '' }}>Buah</option>
                                        <option value="Tambahan" {{ $material->category == 'Tambahan' ? 'selected' : '' }}>Tambahan</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="unit" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Satuan (Unit)</label>
                                    @php
                                        $commonUnits = ['Kg', 'Liter', 'Bungkus', 'Pcs', 'Gram'];
                                        $isOther = !in_array($material->unit, $commonUnits);
                                    @endphp
                                    <select id="unit_select" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none mb-2" onchange="if(this.value=='Other'){document.getElementById('unit_manual_container').classList.remove('hidden'); document.getElementById('unit').value='';}else{document.getElementById('unit_manual_container').classList.add('hidden'); document.getElementById('unit').value=this.value;}">
                                        @foreach($commonUnits as $u)
                                            <option value="{{ $u }}" {{ $material->unit == $u ? 'selected' : '' }}>{{ $u }}</option>
                                        @endforeach
                                        <option value="Other" {{ $isOther ? 'selected' : '' }}>Lainnya...</option>
                                    </select>
                                    <input type="hidden" name="unit" id="unit" value="{{ $material->unit }}">
                                    <div id="unit_manual_container" class="{{ $isOther ? '' : 'hidden' }}">
                                        <input type="text" id="unit_manual" value="{{ $isOther ? $material->unit : '' }}" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Ketik satuan manual..." oninput="document.getElementById('unit').value=this.value">
                                    </div>
                                </div>

                                <div>
                                    <label for="price" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Harga per Satuan</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                                        <input type="number" name="price" id="price" value="{{ old('price', $material->price) }}" required
                                            class="w-full pl-14 pr-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label for="expiry_date" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tanggal Kadaluarsa</label>
                                    <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $material->expiry_date) }}"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label for="stock" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Stok Saat Ini</label>
                                    <input type="number" step="0.01" name="stock" id="stock" value="{{ old('stock', $material->stock) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
