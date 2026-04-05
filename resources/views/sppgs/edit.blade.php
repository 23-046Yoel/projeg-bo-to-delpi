<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('sppgs.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ isset($sppg) ? __('Edit Kitchen') : __('New Kitchen') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">{{ isset($sppg) ? 'Update Detail Dapur & Akses' : 'Tambah Unit Dapur Baru' }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ isset($sppg) ? route('sppgs.update', $sppg) : route('sppgs.store') }}" method="POST">
                        @csrf
                        @if(isset($sppg))
                            @method('PATCH')
                        @endif

                        <div class="space-y-8">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Kitchen Name</label>
                                <div class="relative group">
                                    <input type="text" name="name" id="name" value="{{ old('name', $sppg->name ?? '') }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold focus:ring-4 focus:ring-gold/10 transition-all outline-none"
                                        placeholder="Contoh: Dapur Pusat Jakarta">
                                </div>
                                @error('name') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <!-- Location Field -->
                            <div>
                                <label for="location" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Location / Address</label>
                                <div class="relative group">
                                    <input type="text" name="location" id="location" value="{{ old('location', $sppg->location ?? '') }}"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold focus:ring-4 focus:ring-gold/10 transition-all outline-none"
                                        placeholder="Alamat lengkap unit dapur">
                                </div>
                                @error('location') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone Field -->
                            <div>
                                <label for="phone" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Access Phone (WhatsApp)</label>
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm">+62</div>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $sppg->phone ?? '') }}"
                                        class="w-full pl-16 pr-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy placeholder-gray-400 focus:bg-white focus:border-gold focus:ring-4 focus:ring-gold/10 transition-all outline-none"
                                        placeholder="8123456789">
                                </div>
                                <p class="mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em]">Nomor ini akan digunakan sebagai identitas akses login dapur.</p>
                                @error('phone') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    {{ isset($sppg) ? 'Save Changes' : 'Create Kitchen Unit' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
