<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('beneficiaries.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Tambah Penerima') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Input Data Anak & Riwayat Tumbuh Kembang</p>
            </div>
        </div>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ route('beneficiaries.store') }}" method="POST">
                        @csrf
                        <div class="space-y-10">
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="col-span-1 md:col-span-2">
                                    <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Lengkap Anak</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="Contoh: Ahmad Abdullah">
                                    @error('name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="gender" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Jenis Kelamin</label>
                                    <select id="gender" name="gender" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="dob" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tanggal Lahir</label>
                                    <input type="date" name="dob" id="dob" value="{{ old('dob') }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('dob') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="sppg_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Unit Dapur (SPPG)</label>
                                    <select id="sppg_id" name="sppg_id" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" onchange="filterGroupsBySppg(this.value)">
                                        <option value="">-- Pilih SPPG --</option>
                                        @foreach($sppgs as $sppg)
                                            <option value="{{ $sppg->id }}" {{ auth()->user()->sppg_id == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sppg_id') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                    <p class="mt-2 text-[9px] text-gray-400 font-bold uppercase tracking-widest italic leading-relaxed">Pilih SPPG dulu untuk filter daftar sekolah.</p>
                                </div>

                                <div>
                                    <label for="beneficiary_group_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Asal Sekolah / Kelompok</label>
                                    <select id="beneficiary_group_id" name="beneficiary_group_id" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <option value="">-- Pilih SPPG dulu --</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" data-sppg="{{ $group->sppg_id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('beneficiary_group_id') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="category" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Kategori Penerima</label>
                                    <select id="category" name="category" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <option value="Anak Sekolah">Anak Sekolah</option>
                                        <option value="Ibu Hamil">Ibu Hamil</option>
                                        <option value="Ibu Menyusui">Ibu Menyusui</option>
                                        <option value="Balita">Balita</option>
                                    </select>
                                    @error('category') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Guardian Information -->
                            <div class="pt-10 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="parent_name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Orang Tua / Wali</label>
                                    <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="Nama Ibu atau Ayah">
                                </div>

                                <div>
                                    <label for="guardian_phone" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">No. HP Wali</label>
                                    <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone') }}"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <!-- Physical Metrics -->
                            <div class="pt-10 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="height" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tinggi Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="height" id="height" value="{{ old('height') }}"
                                            class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gold uppercase tracking-widest">CM</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="weight" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Berat Badan</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}"
                                            class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gold uppercase tracking-widest">KG</span>
                                    </div>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label for="allergies" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Alergi (Opsional)</label>
                                    <textarea id="allergies" name="allergies" rows="2"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="Sebutkan alergi jika ada, atau kosongkan jika tidak ada">{{ old('allergies') }}</textarea>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label for="address" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tempat Tinggal / Alamat</label>
                                    <textarea id="address" name="address" rows="3"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="Masukkan alamat lengkap rumah">{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    Simpan Data Penerima
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simpan semua option group dengan data-sppg
        const allGroupOptions = Array.from(document.querySelectorAll('#beneficiary_group_id option'));

        function filterGroupsBySppg(sppgId) {
            const groupSelect = document.getElementById('beneficiary_group_id');
            const currentVal = groupSelect.value;

            // Kosongkan dropdown
            groupSelect.innerHTML = '';

            // Tambah placeholder
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = sppgId ? '-- Pilih Sekolah --' : '-- Pilih SPPG dulu --';
            groupSelect.appendChild(placeholder);

            if (!sppgId) return;

            // Filter & tampilkan hanya group dari SPPG terpilih
            let count = 0;
            allGroupOptions.forEach(opt => {
                if (opt.value && opt.dataset.sppg == sppgId) {
                    const newOpt = document.createElement('option');
                    newOpt.value = opt.value;
                    newOpt.textContent = opt.textContent;
                    newOpt.dataset.sppg = opt.dataset.sppg;
                    if (opt.value == currentVal) newOpt.selected = true;
                    groupSelect.appendChild(newOpt);
                    count++;
                }
            });

            if (count === 0) {
                const empty = document.createElement('option');
                empty.value = '';
                empty.textContent = '(Belum ada sekolah untuk SPPG ini)';
                empty.disabled = true;
                groupSelect.appendChild(empty);
            }
        }

        // Jalankan filter saat halaman load (jika ada SPPG yang sudah terpilih)
        document.addEventListener('DOMContentLoaded', function() {
            const sppgSelect = document.getElementById('sppg_id');
            if (sppgSelect.value) {
                filterGroupsBySppg(sppgSelect.value);
                // Restore nilai group jika ada old input
                @if(old('beneficiary_group_id'))
                document.getElementById('beneficiary_group_id').value = '{{ old('beneficiary_group_id') }}';
                @endif
            }
        });
    </script>
</x-app-layout>
