<x-app-layout>
    <style>
        .paper-container {
            background-color: #f3f4f6;
            padding: 40px 20px;
            min-height: 100vh;
        }
        .paper {
            background: white;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 2cm;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            font-family: 'Times New Roman', serif;
            color: black;
            font-size: 11pt;
            line-height: 1.5;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-transform: uppercase;
            margin-bottom: 2pt;
        }
        .header-sub {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            text-transform: uppercase;
            margin-bottom: 10pt;
        }
        .paper-input {
            border: none;
            border-bottom: 1px solid #000;
            padding: 0 5px;
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            background: transparent;
        }
        .paper-input:focus {
            outline: none;
            border-bottom: 2px solid #d4af37;
            background: #fff9e6;
        }
        table.paper-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15pt 0;
        }
        table.paper-table th, table.paper-table td {
            border: 1.5px solid black;
            padding: 5pt;
        }
        table.paper-table th {
            text-align: center;
            font-weight: bold;
        }
        .section-title {
            font-weight: bold;
            text-decoration: none;
            margin-top: 15pt;
            margin-bottom: 5pt;
        }
        .doc-area {
            border: 2px dashed #999;
            height: 200pt;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #94a3b8;
            margin: 10pt 0;
        }
        .sticky-save {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
        }
    </style>

    <div class="paper-container">
        <form action="{{ route('reports.lpj-sppg.store') }}" method="POST">
            @csrf
            
            <div class="paper">
                <!-- PAGE 1: MAIN REPORT -->
                <div class="header-title">LAPORAN PERTANGGUNGJAWABAN (LPJ) 2 MINGGUAN</div>
                <div class="header-sub">SATUAN PELAYANAN PEMENUHAN GIZI (SPPG) BALIMBINGAN 2</div>
                
                <div style="text-align: center; font-weight: bold; margin-top: 10pt;">
                    Periode: <input type="date" name="period_start" class="paper-input" style="width: 120pt;" required> 
                    s.d. <input type="date" name="period_end" class="paper-input" style="width: 120pt;" required> 2026
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
                            <td><input type="number" name="target_peserta" value="{{ $data['target_peserta'] }}" oninput="calcBeneficiaries()" class="w-full border-none p-0 text-center font-bold"></td>
                            <td><input type="number" name="realisasi_peserta" oninput="calcBeneficiaries()" class="w-full border-none p-0 text-center font-bold"></td>
                            <td class="text-xs">Sesuai Presensi Sekolah</td>
                        </tr>
                        <tr>
                            <td>Pendidik & Tenaga Kependidikan</td>
                            <td><input type="number" name="target_pendidik" value="{{ $data['target_pendidik'] }}" oninput="calcBeneficiaries()" class="w-full border-none p-0 text-center font-bold"></td>
                            <td><input type="number" name="realisasi_pendidik" oninput="calcBeneficiaries()" class="w-full border-none p-0 text-center font-bold"></td>
                            <td class="text-xs">Pendamping Makan</td>
                        </tr>
                        <tr>
                            <td>Kelompok 3B (Bumil, Busui, Balita)</td>
                            <td><input type="number" name="target_3b" value="{{ $data['target_3b'] }}" oninput="calcBeneficiaries()" class="w-full border-none p-0 text-center font-bold"></td>
                            <td><input type="number" name="realisasi_3b" oninput="calcBeneficiaries()" class="w-full border-none p-0 text-center font-bold"></td>
                            <td class="text-xs">Data Puskesmas/Desa</td>
                        </tr>
                        <tr class="font-bold">
                            <td class="text-center">TOTAL</td>
                            <td><input type="number" id="total_target" disabled class="w-full border-none p-0 text-center font-bold bg-gray-50" value="{{ $data['target_peserta'] + $data['target_pendidik'] + $data['target_3b'] }}"></td>
                            <td><input type="number" id="total_realisasi" disabled class="w-full border-none p-0 text-center font-bold bg-gray-50" placeholder="0"></td>
                            <td></td>
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
                            <td><input type="number" name="anggaran_bahan" oninput="calcFinance()" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" name="realisasi_bahan" oninput="calcFinance()" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" id="saldo_bahan" disabled class="w-full border-none p-0 text-right font-bold bg-gray-50"></td>
                        </tr>
                        <tr>
                            <td>Biaya Operasional (Relawan, Gas, dll)</td>
                            <td><input type="number" name="anggaran_ops" oninput="calcFinance()" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" name="realisasi_ops" oninput="calcFinance()" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" id="saldo_ops" disabled class="w-full border-none p-0 text-right font-bold bg-gray-50"></td>
                        </tr>
                        <tr>
                            <td>Insentif Fasilitas (Fixed Cost)</td>
                            <td><input type="number" name="anggaran_insentif" oninput="calcFinance()" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" name="realisasi_insentif" oninput="calcFinance()" class="w-full border-none p-0 text-right font-bold"></td>
                            <td><input type="number" id="saldo_insentif" disabled class="w-full border-none p-0 text-right font-bold bg-gray-50"></td>
                        </tr>
                        <tr class="font-bold">
                            <td>TOTAL PENGELUARAN</td>
                            <td><input type="number" id="total_anggaran" disabled class="w-full border-none p-0 text-right font-bold bg-gray-50"></td>
                            <td><input type="number" id="total_realisasi_dana" disabled class="w-full border-none p-0 text-right font-bold bg-gray-50"></td>
                            <td><input type="number" id="total_saldo" disabled class="w-full border-none p-0 text-right font-bold bg-gray-50"></td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 30pt; display: flex; justify-content: space-between;">
                    <div style="text-align: center; width: 45%;">
                        Mengetahui,<br><b>Ketua Yayasan</b>
                        <div style="height: 50pt;"></div>
                        ( <input type="text" name="ketua_yayasan" value="{{ $data['ketua_yayasan'] }}" class="paper-input" style="width: 140pt;"> )
                    </div>
                    <div style="text-align: center; width: 45%;">
                        Balimbingan, <input type="date" name="report_date" class="paper-input" style="width: 100pt;" value="{{ $data['report_date'] }}"> 2026<br>
                        <b>Kepala SPPG Balimbingan 2</b>
                        <div style="height: 50pt;"></div>
                        ( <input type="text" name="head_sppg_nama" value="{{ $data['head_sppg_nama'] }}" class="paper-input" style="width: 140pt;"> )
                    </div>
                </div>

                <div style="page-break-after: always; height: 50pt;"></div>

                <!-- PAGE 2: LAMPIRAN II -->
                <div class="header-sub">LAMPIRAN II: SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK (SPTJM)</div>
                <hr style="border-top: 2px solid black;">
                <p style="margin-top: 20pt;">Saya yang bertandatangan di bawah ini, Kepala SPPG Balimbingan 2, menyatakan dengan sesungguhnya bahwa:</p>
                <ol style="margin-left: 20pt; line-height: 1.8;">
                    <li>Bertanggung jawab penuh atas kebenaran formil dan materiil atas penggunaan dana Bantuan Pemerintah MBG periode ini.</li>
                    <li>Telah menggunakan dana sesuai peruntukan yang diatur dalam Juknis.</li>
                    <li>Bersedia menyimpan seluruh bukti asli transaksi untuk keperluan audit di kemudian hari.</li>
                </ol>

                <div style="float: right; width: 180pt; text-align: center; margin-top: 40pt;">
                    Balimbingan, .......................... 2026
                    <div style="border: 1px solid black; padding: 15pt 5pt; width: 60pt; margin: 10pt auto; font-size: 8pt;">METERAI<br>10.000</div>
                    ( <input type="text" class="paper-input" style="width: 130pt;" value="{{ $data['head_sppg_nama'] }}"> )<br>
                    Kepala SPPG Balimbingan 2
                </div>
                <div style="clear: both;"></div>

                <div style="page-break-after: always; height: 50pt;"></div>

                <!-- PAGE 3: LAMPIRAN IV -->
                <div class="header-sub">LAMPIRAN IV: UJI ORGANOLEPTIK & DOKUMENTASI</div>
                <hr style="border-top: 2px solid black;">
                
                <div style="font-weight: bold; margin-top: 15pt;">Formulir Ringkasan Uji Organoleptik</div>
                <table class="paper-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Sekolah / Sasaran</th>
                            <th style="width: 15%;">Rasa</th>
                            <th style="width: 15%;">Aroma</th>
                            <th style="width: 15%;">Tekstur</th>
                            <th style="width: 15%;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="organo-tbody">
                        <tr>
                            <td><input type="text" name="organoleptik_data[0][sekolah]" class="w-full border-none p-0" placeholder="SDN ............."></td>
                            <td><input type="text" name="organoleptik_data[0][rasa]" class="w-full border-none p-0 text-center" value="Layak"></td>
                            <td><input type="text" name="organoleptik_data[0][aroma]" class="w-full border-none p-0 text-center" value="Segar"></td>
                            <td><input type="text" name="organoleptik_data[0][tekstur]" class="w-full border-none p-0 text-center" value="Baik"></td>
                            <td><input type="text" name="organoleptik_data[0][status]" class="w-full border-none p-0 text-center" value="Diterima"></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" onclick="addOrgano()" class="text-xs text-blue-600 font-bold no-print">+ Tambah Baris Sekolah</button>

                <div style="font-weight: bold; margin-top: 30pt;">Dokumentasi Kegiatan (Tempel Foto Open Camera Di Sini)</div>
                <div class="doc-area font-bold uppercase">
                    [ AREA PENEMPELAN FOTO KEGIATAN ]<br>
                    (Masak, Packing, Distribusi, dan Foto Bersama Siswa)
                </div>
            </div>

            <div class="sticky-save">
                <button type="submit" class="bg-royal-navy hover:bg-gold text-white font-black px-8 py-4 rounded-full shadow-2xl transition-all uppercase tracking-widest flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>

    <script>
        function calcBeneficiaries() {
            const target_peserta = parseInt(document.getElementsByName('target_peserta')[0].value) || 0;
            const target_pendidik = parseInt(document.getElementsByName('target_pendidik')[0].value) || 0;
            const target_3b = parseInt(document.getElementsByName('target_3b')[0].value) || 0;
            
            const real_peserta = parseInt(document.getElementsByName('realisasi_peserta')[0].value) || 0;
            const real_pendidik = parseInt(document.getElementsByName('realisasi_pendidik')[0].value) || 0;
            const real_3b = parseInt(document.getElementsByName('realisasi_3b')[0].value) || 0;
            
            document.getElementById('total_target').value = target_peserta + target_pendidik + target_3b;
            document.getElementById('total_realisasi').value = real_peserta + real_pendidik + real_3b;
        }

        function calcFinance() {
            const ang_bahan = parseFloat(document.getElementsByName('anggaran_bahan')[0].value) || 0;
            const real_bahan = parseFloat(document.getElementsByName('realisasi_bahan')[0].value) || 0;
            document.getElementById('saldo_bahan').value = ang_bahan - real_bahan;

            const ang_ops = parseFloat(document.getElementsByName('anggaran_ops')[0].value) || 0;
            const real_ops = parseFloat(document.getElementsByName('realisasi_ops')[0].value) || 0;
            document.getElementById('saldo_ops').value = ang_ops - real_ops;

            const ang_ins = parseFloat(document.getElementsByName('anggaran_insentif')[0].value) || 0;
            const real_ins = parseFloat(document.getElementsByName('realisasi_insentif')[0].value) || 0;
            document.getElementById('saldo_insentif').value = ang_ins - real_ins;

            document.getElementById('total_anggaran').value = ang_bahan + ang_ops + ang_ins;
            document.getElementById('total_realisasi_dana').value = real_bahan + real_ops + real_ins;
            document.getElementById('total_saldo').value = (ang_bahan + ang_ops + ang_ins) - (real_bahan + real_ops + real_ins);
        }

        let organoIdx = 1;
        function addOrgano() {
            const html = `
                <tr>
                    <td><input type="text" name="organoleptik_data[${organoIdx}][sekolah]" class="w-full border-none p-0" placeholder="SMP ............."></td>
                    <td><input type="text" name="organoleptik_data[${organoIdx}][rasa]" class="w-full border-none p-0 text-center" value="Layak"></td>
                    <td><input type="text" name="organoleptik_data[${organoIdx}][aroma]" class="w-full border-none p-0 text-center" value="Segar"></td>
                    <td><input type="text" name="organoleptik_data[${organoIdx}][tekstur]" class="w-full border-none p-0 text-center" value="Baik"></td>
                    <td><input type="text" name="organoleptik_data[${organoIdx}][status]" class="w-full border-none p-0 text-center" value="Diterima"></td>
                </tr>
            `;
            document.getElementById('organo-tbody').insertAdjacentHTML('beforeend', html);
            organoIdx++;
        }
    </script>
</x-app-layout>

</x-app-layout>
