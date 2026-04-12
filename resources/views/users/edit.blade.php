<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('users.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Edit Profil Staff') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Ubah Peran & Penugasan Lokasi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-[0_40px_80px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gold/5 -mr-32 -mt-32 rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-royal-navy/5 -ml-16 -mb-16 rounded-full"></div>

                <div class="p-12 relative">
                    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <!-- Name -->
                            <div class="group">
                                <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-gray-300 group-focus-within:text-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-14 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                </div>
                                @error('name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Phone (WhatsApp) -->
                                <div class="group">
                                    <label for="phone" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nomor WhatsApp</label>
                                    <div class="relative">
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                                            class="w-full pl-14 pr-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold">+62</span>
                                    </div>
                                    @error('phone') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <!-- Email -->
                                <div class="group">
                                    <label for="email" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Email (Opsional)</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('email') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="group">
                                <label for="role" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tugaskan Sebagai (Role)</label>
                                <div class="relative">
                                    <select id="role" name="role" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none appearance-none">
                                        @foreach($roles as $value => $label)
                                            <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>{{ $label }} ({{ $value }})</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('role') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <!-- SPPG Assignment -->
                            <div class="group">
                                <label for="sppg_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Unit SPPG / Lokasi Kerja</label>
                                <div class="relative">
                                    <select id="sppg_id" name="sppg_id" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none appearance-none">
                                        <option value="">Belum Ditugaskan / Master Office</option>
                                        @foreach($sppgs as $sppg)
                                            <option value="{{ $sppg->id }}" {{ old('sppg_id', $user->sppg_id) == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                <p class="mt-3 text-[9px] font-bold text-gray-400 uppercase tracking-widest italic leading-relaxed">PENTING: Driver hanya akan muncul di daftar rute jika sudah ditugaskan ke SPPG yang sama dengan Admin penyusun rute.</p>
                                @error('sppg_id') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('users.index') }}" class="text-[10px] font-black text-gray-300 uppercase tracking-widest hover:text-royal-navy transition-colors">Batal</a>
                            <button type="submit" class="px-12 py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
