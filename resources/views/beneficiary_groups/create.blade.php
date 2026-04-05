<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('beneficiary-groups.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Tambah Sekolah') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Input Induk Data Lokasi Penerima Manfaat</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden p-12">
                <form action="{{ route('beneficiary-groups.store') }}" method="POST">
                    @csrf
                    <div class="space-y-8">
                        <div>
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Nama Sekolah / Kelompok</label>
                            <input type="text" name="name" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Contoh: SD Negeri 01 Bukit Tinggi">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Lokasi / Alamat Wilayah</label>
                            <input type="text" name="location" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Contoh: Jl. Merdeka No. 10">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Latitude</label>
                                <input type="number" step="any" name="latitude" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Contoh: 3.010091">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Longitude</label>
                                <input type="number" step="any" name="longitude" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="Contoh: 99.111776">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Estimasi Total Penerima (Perorang)</label>
                            <input type="number" name="total_beneficiaries" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none" placeholder="0">
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                Simpan Data Sekolah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
