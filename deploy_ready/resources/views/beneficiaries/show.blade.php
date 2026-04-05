<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('beneficiaries.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                        {{ __('Profil Penerima') }}
                    </h2>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Informasi Detail Anak & Orang Tua</p>
                </div>
            </div>
            
            <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="btn-premium">
                <span class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    <span>Edit Profil</span>
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-[0_40px_80px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
                <!-- Header / Avatar Section -->
                <div class="bg-royal-navy p-12 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gold/10 rounded-full -ml-16 -mb-16"></div>
                    
                    <div class="relative flex flex-col md:flex-row items-center gap-8">
                        <div class="w-32 h-32 rounded-[2rem] bg-gold flex items-center justify-center text-4xl font-black text-royal-navy shadow-2xl ring-8 ring-white/10">
                            {{ substr($beneficiary->name, 0, 1) }}
                        </div>
                        <div class="text-center md:text-left">
                            <h1 class="text-4xl font-black text-white uppercase tracking-tight font-playfair">{{ $beneficiary->name }}</h1>
                            <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                                <span class="px-4 py-1.5 rounded-full bg-white/10 text-gold text-[10px] font-black uppercase tracking-[0.2em] backdrop-blur-md">
                                    {{ $beneficiary->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                                <span class="px-4 py-1.5 rounded-full bg-white/10 text-white text-[10px] font-black uppercase tracking-[0.2em] backdrop-blur-md">
                                    {{ $beneficiary->age }}
                                </span>
                                <span class="px-4 py-1.5 rounded-full bg-white/10 text-white text-[10px] font-black uppercase tracking-[0.2em] backdrop-blur-md">
                                    {{ $beneficiary->origin }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Left Column: Growth -->
                        <div class="space-y-8">
                            <h3 class="text-[10px] font-black text-gold-dark uppercase tracking-[0.4em] border-b border-gold/10 pb-4">Data Tumbuh Kembang</h3>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <div class="bg-silk p-6 rounded-3xl border border-gray-50">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Tinggi Badan</p>
                                    <p class="text-2xl font-black text-royal-navy">{{ $beneficiary->height ?? '0' }} <span class="text-xs text-slate-400 font-bold">CM</span></p>
                                </div>
                                <div class="bg-silk p-6 rounded-3xl border border-gray-50">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Berat Badan</p>
                                    <p class="text-2xl font-black text-royal-navy">{{ $beneficiary->weight ?? '0' }} <span class="text-xs text-slate-400 font-bold">KG</span></p>
                                </div>
                            </div>

                            <div class="bg-silk p-6 rounded-3xl border border-gray-50">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Lahir</p>
                                <p class="text-lg font-bold text-royal-navy">
                                    {{ $beneficiary->dob ? \Carbon\Carbon::parse($beneficiary->dob)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Right Column: Family -->
                        <div class="space-y-8">
                            <h3 class="text-[10px] font-black text-gold-dark uppercase tracking-[0.4em] border-b border-gold/10 pb-4">Kontak & Keluarga</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-4 bg-slate-50 p-4 rounded-2xl">
                                    <div class="w-10 h-10 rounded-xl bg-royal-navy/5 flex items-center justify-center text-royal-navy">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Wali / Orang Tua</p>
                                        <p class="text-sm font-bold text-royal-navy">{{ $beneficiary->parent_name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 bg-slate-50 p-4 rounded-2xl">
                                    <div class="w-10 h-10 rounded-xl bg-royal-navy/5 flex items-center justify-center text-royal-navy">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">No. HP Aktif</p>
                                        <p class="text-sm font-bold text-royal-navy">{{ $beneficiary->guardian_phone }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-4 bg-slate-50 p-4 rounded-2xl">
                                    <div class="w-10 h-10 rounded-xl bg-royal-navy/5 flex items-center justify-center text-royal-navy mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Alamat Rumah</p>
                                        <p class="text-sm font-bold text-royal-navy leading-relaxed">{{ $beneficiary->address ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mt-12 pt-12 border-t border-gray-50">
                        <h3 class="text-[10px] font-black text-gold-dark uppercase tracking-[0.4em] mb-6">Catatan / Alergi</h3>
                        <div class="bg-silk p-8 rounded-[2rem] border border-gray-50 italic text-slate-500 font-medium">
                            {{ $beneficiary->notes ?? 'Tidak ada catatan khusus untuk penerima ini.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
