<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="mb-8 border-b border-gold/20 pb-6">
                    <h2 class="text-3xl font-black text-royal-navy uppercase tracking-tighter">Edit BERKAS LPJ SPPG</h2>
                    <p class="text-gold-dark font-bold uppercase tracking-widest text-xs mt-2">Laporan Pertanggungjawaban Satuan Pelayanan Pemenuhan Gizi</p>
                </div>

                <form action="{{ route('reports.lpj-sppg.update', $lpj) }}" method="POST" class="space-y-12">
                    @csrf
                    @method('PUT')
                    
                    <!-- Section 1: Informasi Dasar -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Periode Mulai</label>
                            <input type="date" name="period_start" value="{{ $lpj->period_start->format('Y-m-d') }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Periode Selesai</label>
                            <input type="date" name="period_end" value="{{ $lpj->period_end->format('Y-m-d') }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Tanggal Laporan</label>
                            <input type="date" name="report_date" value="{{ $lpj->report_date->format('Y-m-d') }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                    </div>

                    <!-- Section 2: Realisasi Penerima Manfaat -->
                    <div class="bg-silk/30 p-6 rounded-3xl border border-gold/10">
                        <h3 class="text-sm font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-gold/20 flex items-center justify-center text-gold-dark mr-3 italic">I</span>
                            Data Realisasi Penerima Manfaat
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Peserta Didik (PAUD/SD/SMP/SMA)</p>
                                <div class="flex gap-4">
                                    <input type="number" name="target_peserta" value="{{ $lpj->target_peserta }}" placeholder="Target" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                    <input type="number" name="realisasi_peserta" value="{{ $lpj->realisasi_peserta }}" placeholder="Realisasi" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendidik & Tenaga Kependidikan</p>
                                <div class="flex gap-4">
                                    <input type="number" name="target_pendidik" value="{{ $lpj->target_pendidik }}" placeholder="Target" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                    <input type="number" name="realisasi_pendidik" value="{{ $lpj->realisasi_pendidik }}" placeholder="Realisasi" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kelompok 3B (Bumil, Busui, Balita)</p>
                                <div class="flex gap-4">
                                    <input type="number" name="target_3b" value="{{ $lpj->target_3b }}" placeholder="Target" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                    <input type="number" name="realisasi_3b" value="{{ $lpj->realisasi_3b }}" placeholder="Realisasi" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Laporan Penggunaan Dana -->
                    <div class="bg-silk/30 p-6 rounded-3xl border border-gold/10">
                        <h3 class="text-sm font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-gold/20 flex items-center justify-center text-gold-dark mr-3 italic">II</span>
                            Laporan Penggunaan Dana
                        </h3>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                                <div class="md:col-span-2">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Belanja Bahan Baku (At Cost)</p>
                                </div>
                                <input type="number" name="anggaran_bahan" value="{{ $lpj->anggaran_bahan }}" placeholder="Anggaran" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                <input type="number" name="realisasi_bahan" value="{{ $lpj->realisasi_bahan }}" placeholder="Realisasi" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                                <div class="md:col-span-2">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Biaya Operasional (Relawan, Gas, LPJ, dll)</p>
                                </div>
                                <input type="number" name="anggaran_ops" value="{{ $lpj->anggaran_ops }}" placeholder="Anggaran" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                <input type="number" name="realisasi_ops" value="{{ $lpj->realisasi_ops }}" placeholder="Realisasi" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                                <div class="md:col-span-2">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Insentif Fasilitas (Fixed Cost)</p>
                                </div>
                                <input type="number" name="anggaran_insentif" value="{{ $lpj->anggaran_insentif }}" placeholder="Anggaran" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                <input type="number" name="realisasi_insentif" value="{{ $lpj->realisasi_insentif }}" placeholder="Realisasi" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Penandatangan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Ketua Yayasan</label>
                            <input type="text" name="ketua_yayasan" value="{{ $lpj->ketua_yayasan }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nama PPK</label>
                            <input type="text" name="ppk_nama" value="{{ $lpj->ppk_nama }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Kepala SPPG</label>
                            <input type="text" name="head_sppg_nama" value="{{ $lpj->head_sppg_nama }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                    </div>

                    <div class="flex justify-end pt-8">
                        <button type="submit" class="px-10 py-4 bg-royal-navy text-white font-black rounded-2xl hover:bg-gold transition-all shadow-xl hover:shadow-gold/20 uppercase tracking-widest">
                            Update Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
