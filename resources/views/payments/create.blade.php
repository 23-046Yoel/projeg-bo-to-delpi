<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('payments.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Input Transaksi') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Catat Pemasukan atau Pengeluaran Baru</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tanggal Transaksi</label>
                                    <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all">
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Keterangan / Deskripsi</label>
                                    <input type="text" name="description" required placeholder="Contoh: Pembayaran Listrik MBG"
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Jenis Transaksi</label>
                                    <select name="transaction_type" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all">
                                        <option value="Biaya Bahan Baku">Biaya Bahan Baku</option>
                                        <option value="Biaya Operasional">Biaya Operasional</option>
                                        <option value="Insentif Fasilitas">Insentif Fasilitas</option>
                                        <option value="Bantuan Pemerintah">Bantuan Pemerintah (Pemasukan)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Jenis Kas</label>
                                    <select name="cash_type" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all">
                                        <option value="Virtual Akun">Virtual Akun</option>
                                        <option value="Kas Kecil">Kas Kecil</option>
                                    </select>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Terkait Penerima / Anak (Opsional)</label>
                                    <select name="beneficiary_id" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all">
                                        <option value="">-- Tidak Terikat Spesifik --</option>
                                        @foreach($beneficiaries as $b)
                                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-2 text-[9px] text-gray-400 font-bold uppercase tracking-widest italic leading-relaxed">Pilih jika transaksi ini spesifik untuk anak tertentu (misal: pemberian bantuan khusus).</p>
                                </div>
                                
                                {{-- Saldo Awal Reminder --}}
                                <div class="col-span-1 md:col-span-2 bg-royal-navy/5 p-6 rounded-[2rem] border border-royal-navy/10 flex items-start space-x-4">
                                    <div class="w-10 h-10 rounded-xl bg-royal-navy flex items-center justify-center text-gold flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-royal-navy uppercase tracking-widest mb-1">Penting: Saldo Awal</p>
                                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Pastikan Anda telah mengisi "Bantuan Pemerintah" atau saldo awal sebelum mencatat pengeluaran pertama.</p>
                                    </div>
                                </div>
                                
                                <div class="bg-emerald-50 rounded-[2rem] p-6 border border-emerald-100">
                                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-4">Pemasukan (+)</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-sm font-bold text-emerald-400">Rp</span>
                                        <input type="number" name="amount_in" value="0"
                                            class="w-full pl-14 pr-6 py-4 bg-white border-2 border-transparent rounded-2xl text-sm font-black text-emerald-600 focus:border-emerald-500 outline-none transition-all">
                                    </div>
                                </div>

                                <div class="bg-rose-50 rounded-[2rem] p-6 border border-rose-100">
                                    <label class="block text-[10px] font-black text-rose-600 uppercase tracking-[0.2em] mb-4">Pengeluaran (-)</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-sm font-bold text-rose-400">Rp</span>
                                        <input type="number" name="amount_out" value="0"
                                            class="w-full pl-14 pr-6 py-4 bg-white border-2 border-transparent rounded-2xl text-sm font-black text-rose-600 focus:border-rose-500 outline-none transition-all">
                                    </div>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Bukti Transaksi (Opsional)</label>
                                    <div class="relative">
                                        <input type="file" name="file" 
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-4 file:px-8 file:rounded-2xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-royal-navy file:text-gold hover:file:bg-royal-navy/90 file:transition-all cursor-pointer">
                                    </div>
                                    <p class="mt-2 text-[9px] text-gray-400 font-bold uppercase tracking-widest italic">Format: JPG, PNG, PDF (Max 5MB)</p>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    Simpan Transaksi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
