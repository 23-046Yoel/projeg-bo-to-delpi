<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="mb-8 border-b border-gold/20 pb-6">
                    <h2 class="text-3xl font-black text-royal-navy uppercase tracking-tighter">Input BERKAS LPJ SPPG Baru</h2>
                    <p class="text-gold-dark font-bold uppercase tracking-widest text-xs mt-2">Laporan Pertanggungjawaban Satuan Pelayanan Pemenuhan Gizi</p>
                </div>

                <form action="{{ route('reports.lpj-sppg.store') }}" method="POST" class="space-y-12">
                    @csrf
                    
                    <!-- Section 1: Informasi Dasar -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Periode Mulai</label>
                            <input type="date" name="period_start" value="{{ $data['period_start'] }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Periode Selesai</label>
                            <input type="date" name="period_end" value="{{ $data['period_end'] }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Tanggal Laporan</label>
                            <input type="date" name="report_date" value="{{ $data['report_date'] }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
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
                                    <input type="number" name="target_peserta" placeholder="Target" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                    <input type="number" name="realisasi_peserta" placeholder="Realisasi" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendidik & Tenaga Kependidikan</p>
                                <div class="flex gap-4">
                                    <input type="number" name="target_pendidik" placeholder="Target" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                    <input type="number" name="realisasi_pendidik" placeholder="Realisasi" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kelompok 3B (Bumil, Busui, Balita)</p>
                                <div class="flex gap-4">
                                    <input type="number" name="target_3b" placeholder="Target" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                    <input type="number" name="realisasi_3b" placeholder="Realisasi" class="w-1/2 border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
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
                                <input type="number" name="anggaran_bahan" placeholder="Anggaran" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                <input type="number" name="realisasi_bahan" placeholder="Realisasi" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                                <div class="md:col-span-2">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Biaya Operasional (Relawan, Gas, LPJ, dll)</p>
                                </div>
                                <input type="number" name="anggaran_ops" placeholder="Anggaran" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                <input type="number" name="realisasi_ops" placeholder="Realisasi" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                                <div class="md:col-span-2">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Insentif Fasilitas (Fixed Cost)</p>
                                </div>
                                <input type="number" name="anggaran_insentif" placeholder="Anggaran" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                                <input type="number" name="realisasi_insentif" placeholder="Realisasi" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Lampiran III A - Rekap Bahan Pangan -->
                    <div class="bg-silk/30 p-6 rounded-3xl border border-gold/10">
                        <h3 class="text-sm font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex items-center justify-between">
                            <span class="flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-gold/20 flex items-center justify-center text-gold-dark mr-3 italic">III.A</span>
                                Rekapitulasi Bahan Pangan (Harian)
                            </span>
                            <button type="button" @click="addBahanRow()" class="px-4 py-2 bg-gold-dark text-white rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy transition-all">+ Tambah Item Bahan</button>
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs font-bold">
                                <thead>
                                    <tr class="text-[9px] uppercase tracking-widest text-gray-400">
                                        <th class="pb-3 text-left">Tgl</th>
                                        <th class="pb-3 text-left">Jenis Bahan</th>
                                        <th class="pb-3 text-left">Vol</th>
                                        <th class="pb-3 text-left">Sat</th>
                                        <th class="pb-3 text-left">Harga</th>
                                        <th class="pb-3 text-left">Total</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody id="bahan_rows">
                                    <tr class="bahan-row">
                                        <td><input type="text" name="buku_bantu_bahan[0][tgl]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="10/04"></td>
                                        <td><input type="text" name="buku_bantu_bahan[0][jenis]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Beras"></td>
                                        <td><input type="text" name="buku_bantu_bahan[0][vol]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="100"></td>
                                        <td><input type="text" name="buku_bantu_bahan[0][satuan]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Kg"></td>
                                        <td><input type="number" name="buku_bantu_bahan[0][harga]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                                        <td><input type="number" name="buku_bantu_bahan[0][total]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                                        <td class="text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400">×</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 5: Lampiran III B - Rekap Ops -->
                    <div class="bg-silk/30 p-6 rounded-3xl border border-gold/10">
                        <h3 class="text-sm font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex items-center justify-between">
                            <span class="flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-gold/20 flex items-center justify-center text-gold-dark mr-3 italic">III.B</span>
                                Rekapitulasi Operasional & Insentif
                            </span>
                            <button type="button" @click="addOpsRow()" class="px-4 py-2 bg-gold-dark text-white rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy transition-all">+ Tambah Item Ops</button>
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs font-bold">
                                <thead>
                                    <tr class="text-[9px] uppercase tracking-widest text-gray-400">
                                        <th class="pb-3 text-left">Tgl</th>
                                        <th class="pb-3 text-left">Uraian</th>
                                        <th class="pb-3 text-left">Penerima / Toko</th>
                                        <th class="pb-3 text-left">Nominal (Rp)</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody id="ops_rows">
                                    <tr class="ops-row">
                                        <td><input type="text" name="buku_bantu_ops[0][tgl]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="10/04"></td>
                                        <td><input type="text" name="buku_bantu_ops[0][uraian]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Gas Elpiji"></td>
                                        <td><input type="text" name="buku_bantu_ops[0][penerima]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Toko Berkah"></td>
                                        <td><input type="number" name="buku_bantu_ops[0][nominal]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                                        <td class="text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400">×</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 6: Lampiran IV - Organoleptik -->
                    <div class="bg-silk/30 p-6 rounded-3xl border border-gold/10">
                        <h3 class="text-sm font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex items-center justify-between">
                            <span class="flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-gold/20 flex items-center justify-center text-gold-dark mr-3 italic">IV</span>
                                Uji Organoleptik
                            </span>
                            <button type="button" @click="addOrganoleptikRow()" class="px-4 py-2 bg-gold-dark text-white rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy transition-all">+ Tambah Sekolah</button>
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs font-bold">
                                <thead>
                                    <tr class="text-[9px] uppercase tracking-widest text-gray-400">
                                        <th class="pb-3 text-left">Sekolah / Sasaran</th>
                                        <th class="pb-3 text-left">Rasa</th>
                                        <th class="pb-3 text-left">Aroma</th>
                                        <th class="pb-3 text-left">Tekstur</th>
                                        <th class="pb-3 text-left">Status</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody id="organoleptik_rows">
                                    <tr class="organo-row">
                                        <td><input type="text" name="organoleptik_data[0][sekolah]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="SDN 01"></td>
                                        <td><input type="text" name="organoleptik_data[0][rasa]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Layak"></td>
                                        <td><input type="text" name="organoleptik_data[0][aroma]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Segar"></td>
                                        <td><input type="text" name="organoleptik_data[0][tekstur]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Baik"></td>
                                        <td><input type="text" name="organoleptik_data[0][status]" class="w-full border-gray-100 rounded-lg text-xs" placeholder="Diterima"></td>
                                        <td class="text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400">×</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 7: Penandatangan -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-12">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Ketua Yayasan</label>
                            <input type="text" name="ketua_yayasan" value="{{ $data['ketua_yayasan'] }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nama PPK</label>
                            <input type="text" name="ppk_nama" value="{{ $data['ppk_nama'] }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Kepala SPPG</label>
                            <input type="text" name="head_sppg_nama" value="{{ $data['head_sppg_nama'] }}" class="w-full border-gray-200 rounded-xl focus:ring-gold focus:border-gold font-bold">
                        </div>
                    </div>

                    <div class="flex justify-end pt-8">
                        <button type="submit" class="px-10 py-4 bg-royal-navy text-white font-black rounded-2xl hover:bg-gold transition-all shadow-xl hover:shadow-gold/20 uppercase tracking-widest">
                            Simpan Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let bahanIndex = 1;
        function addBahanRow() {
            const html = `
                <tr class="bahan-row">
                    <td><input type="text" name="buku_bantu_bahan[${bahanIndex}][tgl]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="buku_bantu_bahan[${bahanIndex}][jenis]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="buku_bantu_bahan[${bahanIndex}][vol]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="buku_bantu_bahan[${bahanIndex}][satuan]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="number" name="buku_bantu_bahan[${bahanIndex}][harga]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="number" name="buku_bantu_bahan[${bahanIndex}][total]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td class="text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400">×</button></td>
                </tr>
            `;
            document.getElementById('bahan_rows').insertAdjacentHTML('beforeend', html);
            bahanIndex++;
        }

        let opsIndex = 1;
        function addOpsRow() {
            const html = `
                <tr class="ops-row">
                    <td><input type="text" name="buku_bantu_ops[${opsIndex}][tgl]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="buku_bantu_ops[${opsIndex}][uraian]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="buku_bantu_ops[${opsIndex}][penerima]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="number" name="buku_bantu_ops[${opsIndex}][nominal]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td class="text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400">×</button></td>
                </tr>
            `;
            document.getElementById('ops_rows').insertAdjacentHTML('beforeend', html);
            opsIndex++;
        }

        let organoIndex = 1;
        function addOrganoleptikRow() {
            const html = `
                <tr class="organo-row">
                    <td><input type="text" name="organoleptik_data[${organoIndex}][sekolah]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="organoleptik_data[${organoIndex}][rasa]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="organoleptik_data[${organoIndex}][aroma]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="organoleptik_data[${organoIndex}][tekstur]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td><input type="text" name="organoleptik_data[${organoIndex}][status]" class="w-full border-gray-100 rounded-lg text-xs"></td>
                    <td class="text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400">×</button></td>
                </tr>
            `;
            document.getElementById('organoleptik_rows').insertAdjacentHTML('beforeend', html);
            organoIndex++;
        }
    </script>
</x-app-layout>
