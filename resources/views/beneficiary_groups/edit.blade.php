<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('beneficiary-groups.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    Edit Penerima Manfaat
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Perbarui Induk Data Lokasi Penerima Manfaat</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden p-12">
                <form action="{{ route('beneficiary-groups.update', $beneficiaryGroup) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tipe Penerima</label>
                            <select name="type" id="type-selector" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                <option value="sekolah" {{ $beneficiaryGroup->type == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                                <option value="posyandu" {{ $beneficiaryGroup->type == 'posyandu' ? 'selected' : '' }}>Posyandu</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Dapur (SPPG)</label>
                            <select name="sppg_id" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                @foreach($sppgs as $sppg)
                                    <option value="{{ $sppg->id }}" {{ $beneficiaryGroup->sppg_id == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Unit</label>
                            <input type="text" name="name" value="{{ $beneficiaryGroup->name }}" required class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Lokasi / Alamat Wilayah</label>
                            <input type="text" name="location" value="{{ $beneficiaryGroup->location }}" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Contoh: Karang Sari, Gunung Maligas">
                        </div>

                        {{-- Section Sekolah --}}
                        <div id="section-sekolah" class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 {{ $beneficiaryGroup->type == 'posyandu' ? 'hidden' : '' }}">
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Jumlah Siswa</label>
                                <input type="number" name="count_siswa" value="{{ $beneficiaryGroup->count_siswa }}" class="w-full px-6 py-4 bg-blue-50/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-blue-300 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Guru & Staff</label>
                                <input type="number" name="count_guru" value="{{ $beneficiaryGroup->count_guru }}" class="w-full px-6 py-4 bg-blue-50/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-blue-300 transition-all outline-none">
                            </div>
                        </div>

                        {{-- Section Posyandu --}}
                        <div id="section-posyandu" class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6 {{ $beneficiaryGroup->type == 'sekolah' ? 'hidden' : '' }}">
                            <div>
                                <label class="block text-[10px] font-black text-pink-600 uppercase tracking-[0.2em] mb-3">Ibu Hamil</label>
                                <input type="number" name="count_hamil" value="{{ $beneficiaryGroup->count_hamil }}" class="w-full px-6 py-4 bg-pink-50/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-pink-300 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-pink-600 uppercase tracking-[0.2em] mb-3">Ibu Menyusui</label>
                                <input type="number" name="count_menyusui" value="{{ $beneficiaryGroup->count_menyusui }}" class="w-full px-6 py-4 bg-pink-50/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-pink-300 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-pink-600 uppercase tracking-[0.2em] mb-3">Balita</label>
                                <input type="number" name="count_balita" value="{{ $beneficiaryGroup->count_balita }}" class="w-full px-6 py-4 bg-pink-50/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-pink-300 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-12">
                        <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                            Perbarui Data Penerima
                        </button>
                    </div>
                </form>
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
