<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('beneficiaries.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
            lj    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Edit Penerima') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Ubah Data Anak: {{ $beneficiary->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-10">
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="col-span-1 md:col-span-2">
                                    <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Lengkap Anak</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $beneficiary->name) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="gender" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Jenis Kelamin</label>
                                    <select id="gender" name="gender" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <option value="L" {{ old('gender', $beneficiary->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender', $beneficiary->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="dob" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tanggal Lahir</label>
                                    <input type="date" name="dob" id="dob" value="{{ old('dob', $beneficiary->dob) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('dob') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="beneficiary_group_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Asal Sekolah / Kelompok</label>
                                    <select id="beneficiary_group_id" name="beneficiary_group_id" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" {{ $beneficiary->beneficiary_group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('beneficiary_group_id') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="category" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Kategori Penerima</label>
                                    <select id="category" name="category" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <option value="Anak Sekolah" {{ $beneficiary->category == 'Anak Sekolah' ? 'selected' : '' }}>Anak Sekolah</option>
                                        <option value="Ibu Hamil" {{ $beneficiary->category == 'Ibu Hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                                        <option value="Ibu Menyusui" {{ $beneficiary->category == 'Ibu Menyusui' ? 'selected' : '' }}>Ibu Menyusui</option>
                                        <option value="Balita" {{ $beneficiary->category == 'Balita' ? 'selected' : '' }}>Balita</option>
                                    </select>
                                    @error('category') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Guardian Information -->
                            <div class="pt-10 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="parent_name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Orang Tua / Wali</label>
                                    <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name', $beneficiary->parent_name) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="Nama Ibu atau Ayah">
                                    @error('parent_name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="guardian_phone" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">No. HP Wali</label>
                                    <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone', $beneficiary->guardian_phone) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="08xxxxxxxxxx">
                                    @error('guardian_phone') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label for="origin" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Asal Sekolah / Wilayah</label>
                                    <input type="text" name="origin" id="origin" value="{{ old('origin', $beneficiary->origin) }}"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none">
                                </div>
                            </div>

                            <!-- Physical Metrics -->
                            <div class="pt-10 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="height" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tinggi Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="height" id="height" value="{{ old('height', $beneficiary->height) }}"
                                            class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gold uppercase tracking-widest">CM</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="weight" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Berat Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight', $beneficiary->weight) }}"
                                            class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gold uppercase tracking-widest">KG</span>
                                    </div>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label for="allergies" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Alergi (Opsional)</label>
                                    <textarea id="allergies" name="allergies" rows="2"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="Sebutkan alergi jika ada, atau kosongkan jika tidak ada">{{ old('allergies', $beneficiary->allergies) }}</textarea>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label for="address" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tempat Tinggal / Alamat</label>
                                    <textarea id="address" name="address" rows="3"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="Masukkan alamat lengkap rumah">{{ old('address', $beneficiary->address) }}</textarea>
                                </div>
                            </div>

                            <div class="pt-6 flex items-center justify-between gap-6">
                                <button type="submit" class="flex-1 py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    Perbarui Data
                                </button>
                                
                                <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-8 py-5 border-2 border-red-100 text-red-500 font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-red-50 transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
