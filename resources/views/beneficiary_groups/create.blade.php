<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('beneficiary-groups.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    Tambah Penerima Manfaat
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Input Induk Data Lokasi Penerima Manfaat</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-12">
            {{-- Form Section --}}
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden p-12">
                <form action="{{ route('beneficiary-groups.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tipe Lokasi</label>
                            <select name="type" id="type-selector" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                <option value="Sekolah">Sekolah</option>
                                <option value="Posyandu">Posyandu</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Kategori Penerima</label>
                            <select name="category" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                <option value="Anak Sekolah">Anak Sekolah</option>
                                <option value="Guru & Staf">Guru & Staf</option>
                                <option value="Kader Posyandu">Kader Posyandu</option>
                                <option value="Ibu Hamil/Menyusui">Ibu Hamil/Menyusui</option>
                                <option value="Balita">Balita</option>
                            </select>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Unit (Nama Sekolah / Nama Posyandu)</label>
                            <input type="text" name="name" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Contoh: SD Negeri 095560 Karang Sari">
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Lokasi / Alamat Wilayah</label>
                            <input type="text" name="location" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Contoh: Karang Sari, Gunung Maligas">
                        </div>

                        {{-- Estimasi Porsi --}}
                        <div class="col-span-1 md:col-span-2 bg-royal-navy/5 p-8 rounded-[2rem] border border-royal-navy/10">
                            <h3 class="text-[10px] font-black text-royal-navy uppercase tracking-[0.3em] mb-6 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                Estimasi Porsi Makan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-royal-navy/60 uppercase tracking-[0.2em] mb-3">Porsi Besar (Anak SMP/Dewasa)</label>
                                    <input type="number" name="porsi_besar" class="w-full px-6 py-4 bg-white border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:border-gold transition-all outline-none" value="0">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-royal-navy/60 uppercase tracking-[0.2em] mb-3">Porsi Kecil (Anak SD/Paud)</label>
                                    <input type="number" name="porsi_kecil" class="w-full px-6 py-4 bg-white border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:border-gold transition-all outline-none" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-12">
                        <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                            Simpan & Daftarkan Penerima
                        </button>
                    </div>
                </form>
            </div>

            {{-- List Section --}}
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-black text-royal-navy font-playfair uppercase">Unit Terdaftar</h3>
                    <span class="px-4 py-1.5 bg-royal-navy/5 text-royal-navy text-[10px] font-black rounded-full uppercase tracking-widest">{{ count($groups) }} Lokasi</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Unit / Tipe</th>
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kategori</th>
                                <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Porsi B / K</th>
                                <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($groups as $group)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-4">
                                    <span class="block text-sm font-black text-royal-navy">{{ $group->name }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $group->type }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="px-3 py-1 bg-silk text-royal-navy text-[10px] font-black rounded-lg uppercase tracking-widest border border-royal-navy/5">{{ $group->category }}</span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <span class="text-sm font-black text-royal-navy">{{ $group->porsi_besar }}</span>
                                    <span class="text-gray-300 mx-1">/</span>
                                    <span class="text-sm font-black text-royal-navy">{{ $group->porsi_kecil }}</span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <a href="{{ route('beneficiary-groups.edit', $group) }}" class="text-royal-navy hover:text-gold transition-colors inline-block">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const typeSelector = document.getElementById('type-selector');
        const sectionSekolah = document.getElementById('section-sekolah');
        const sectionPosyandu = document.getElementById('section-posyandu');

        typeSelector.addEventListener('change', function() {
            if (this.value === 'sekolah') {
                sectionSekolah.classList.remove('hidden');
                sectionPosyandu.classList.add('hidden');
            } else {
                sectionSekolah.classList.add('hidden');
                sectionPosyandu.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
