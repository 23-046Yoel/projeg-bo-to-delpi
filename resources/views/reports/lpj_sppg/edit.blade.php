<x-app-layout>
    <style>
        .paper-container { background-color: #f3f4f6; padding: 40px 20px; min-height: 100vh; }
        .paper { background: white; width: 210mm; min-height: 297mm; margin: 0 auto; padding: 2cm; box-shadow: 0 0 20px rgba(0,0,0,0.1); font-family: 'Times New Roman', serif; color: black; font-size: 11pt; line-height: 1.5; }
        .header-title { text-align: center; font-weight: bold; font-size: 14pt; text-transform: uppercase; margin-bottom: 2pt; }
        .header-sub { text-align: center; font-weight: bold; font-size: 12pt; text-transform: uppercase; margin-bottom: 10pt; }
        .paper-input { border: none; border-bottom: 1px solid #000; padding: 0 5px; font-family: 'Times New Roman', serif; font-size: 11pt; font-weight: bold; text-align: center; background: transparent; }
        .paper-input:focus { outline: none; border-bottom: 2px solid #d4af37; background: #fff9e6; }
        table.paper-table { width: 100%; border-collapse: collapse; margin: 15pt 0; }
        table.paper-table th, table.paper-table td { border: 1.5px solid black; padding: 5pt; }
        table.paper-table th { text-align: center; font-weight: bold; }
        .section-title { font-weight: bold; margin-top: 15pt; margin-bottom: 5pt; }
        .doc-area { border: 2px dashed #999; height: 200pt; display: flex; align-items: center; justify-content: center; text-align: center; color: #94a3b8; margin: 10pt 0; }
        .sticky-save { position: fixed; bottom: 30px; right: 30px; z-index: 100; }
    </style>

    <div class="paper-container">
        <form action="{{ route('reports.lpj-sppg.update', $lpj) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="paper">
                <div class="header-title">LAPORAN PERTANGGUNGJAWABAN (LPJ) 2 MINGGUAN</div>
                <div class="header-sub">SATUAN PELAYANAN PEMENUHAN GIZI (SPPG) BALIMBINGAN 2</div>
                
                <div style="text-align: center; font-weight: bold; margin-top: 10pt;">
                    Periode: <input type="date" name="period_start" class="paper-input" value="{{ $lpj->period_start->format('Y-m-d') }}" style="width: 120pt;"> 
                    s.d. <input type="date" name="period_end" class="paper-input" value="{{ $lpj->period_end->format('Y-m-d') }}" style="width: 120pt;"> 2026
                </div>

                <hr style="border: none; border-top: 2.5px solid black; margin-top: 10pt;">

                <div class="section-title">I. LAPORAN PELAKSANAAN KEGIATAN</div>
                <div style="font-weight: bold; margin-bottom: 5pt;">1.1 Data Realisasi Penerima Manfaat</div>

                <table class="paper-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Kategori Penerima</th>
                            <th style="width: 15%;">Target (Jiwa)</th>
                            <th style="width: 15%;">Realisasi (Jiwa)</th>
                            <th style="width: 30%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Peserta Didik (PAUD/SD/SMP/SMA)</td>
                            <td><input type="number" name="target_peserta" value="{{ $lpj->target_peserta }}" class="w-full border-none p-0 text-center font-bold"></td>
                            <td><input type="number" name="realisasi_peserta" value="{{ $lpj->realisasi_peserta }}" class="w-full border-none p-0 text-center font-bold"></td>
                            <td class="text-xs">Sesuai Presensi Sekolah</td>
                        </tr>
                        <tr>
                            <td>Pendidik & Tenaga Kependidikan</td>
                            <td><input type="number" name="target_pendidik" value="{{ $lpj->target_pendidik }}" class="w-full border-none p-0 text-center font-bold"></td>
                            <td><input type="number" name="realisasi_pendidik" value="{{ $lpj->realisasi_pendidik }}" class="w-full border-none p-0 text-center font-bold"></td>
                            <td class="text-xs">Pendamping Makan</td>
                        </tr>
                        <tr>
                            <td>Kelompok 3B (Bumil, Busui, Balita)</td>
                            <td><input type="number" name="target_3b" value="{{ $lpj->target_3b }}" class="w-full border-none p-0 text-center font-bold"></td>
                            <td><input type="number" name="realisasi_3b" value="{{ $lpj->realisasi_3b }}" class="w-full border-none p-0 text-center font-bold"></td>
                            <td class="text-xs">Data Puskesmas/Desa</td>
                        </tr>
                    </tbody>
                </table>

                <div class="section-title">II. LAPORAN PENGGUNAAN DANA</div>
                <table class="paper-table">
                    <thead>
                        <tr>
                            <th style="width: 45%;">Uraian Komponen Biaya</th>
                            <th style="width: 18%;">Anggaran (Rp)</th>
                            <th style="width: 18%;">Realisasi (Rp)</th>
                            <th style="width: 19%;">Saldo (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Belanja Bahan Baku (At Cost)</td>
                            <td><input type="number" name="anggaran_bahan" value="{{ $lpj->anggaran_bahan }}" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" name="realisasi_bahan" value="{{ $lpj->realisasi_bahan }}" class="w-full border-none p-0 text-right font-bold"></td>
                            <td class="text-right font-bold">{{ number_format($lpj->anggaran_bahan - $lpj->realisasi_bahan) }}</td>
                        </tr>
                        <tr>
                            <td>Biaya Operasional (Relawan, Gas, dll)</td>
                            <td><input type="number" name="anggaran_ops" value="{{ $lpj->anggaran_ops }}" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" name="realisasi_ops" value="{{ $lpj->realisasi_ops }}" class="w-full border-none p-0 text-right font-bold"></td>
                            <td class="text-right font-bold">{{ number_format($lpj->anggaran_ops - $lpj->realisasi_ops) }}</td>
                        </tr>
                        <tr>
                            <td>Insentif Fasilitas (Fixed Cost)</td>
                            <td><input type="number" name="anggaran_insentif" value="{{ $lpj->anggaran_insentif }}" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" name="realisasi_insentif" value="{{ $lpj->realisasi_insentif }}" class="w-full border-none p-0 text-right font-bold"></td>
                            <td class="text-right font-bold">{{ number_format($lpj->anggaran_insentif - $lpj->realisasi_insentif) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 30pt; display: flex; justify-content: space-between;">
                    <div style="text-align: center; width: 45%;">
                        Mengetahui,<br><b>Ketua Yayasan</b>
                        <div style="height: 50pt;"></div>
                        ( <input type="text" name="ketua_yayasan" value="{{ $lpj->ketua_yayasan }}" class="paper-input" style="width: 140pt;"> )
                    </div>
                    <div style="text-align: center; width: 45%;">
                        Balimbingan, <input type="date" name="report_date" class="paper-input" value="{{ $lpj->report_date->format('Y-m-d') }}" style="width: 100pt;"> 2026<br>
                        <b>Kepala SPPG Balimbingan 2</b>
                        <div style="height: 50pt;"></div>
                        ( <input type="text" name="head_sppg_nama" value="{{ $lpj->head_sppg_nama }}" class="paper-input" style="width: 140pt;"> )
                    </div>
                </div>
            </div>

            <div class="sticky-save">
                <button type="submit" class="bg-royal-navy hover:bg-gold text-white font-black px-8 py-4 rounded-full shadow-2xl transition-all uppercase tracking-widest flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Update Laporan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
