<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('users.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Pendaftaran Staff Baru') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Buat Akun Driver atau Admin Baru</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-[0_40px_80px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden relative">
                <div class="p-12 relative">
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Name -->
                            <div class="group col-span-1 md:col-span-2">
                                <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none"
                                    placeholder="Nama Staff">
                                @error('name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone (WhatsApp) - PRIMARY LOGIN -->
                            <div class="group">
                                <label for="phone" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nomor WhatsApp (Untuk Login OTP)</label>
                                <div class="relative">
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                        class="w-full pl-14 pr-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none"
                                        placeholder="08123456789">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold">+62</span>
                                </div>
                                @error('phone') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email (Optional) -->
                            <div class="group">
                                <label for="email" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Email (Opsional)</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none"
                                    placeholder="staff@example.com">
                                @error('email') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <!-- Role -->
                            <div class="group">
                                <label for="role" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tugaskan Sebagai (Role)</label>
                                <select id="role" name="role" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none appearance-none">
                                    @foreach($roles as $key => $title)
                                        <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>{{ $title }}</option>
                                    @endforeach
                                </select>
                                @error('role') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <!-- SPPG Assignment -->
                            <div class="group">
                                <label for="sppg_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Unit SPPG / Lokasi Kerja</label>
                                <select id="sppg_id" name="sppg_id" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none appearance-none">
                                    <option value="">Belum Ditugaskan / Master Office</option>
                                    @foreach($sppgs as $sppg)
                                        <option value="{{ $sppg->id }}" {{ old('sppg_id') == $sppg->id ? 'selected' : '' }}>{{ $sppg->name }}</option>
                                    @endforeach
                                </select>
                                @error('sppg_id') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('users.index') }}" class="text-[10px] font-black text-gray-300 uppercase tracking-widest hover:text-royal-navy transition-colors">Batal</a>
                            <button type="submit" class="px-12 py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                Daftarkan Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
