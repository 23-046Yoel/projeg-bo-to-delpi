<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LPJ SPPG - {{ $lpj->period_start->format('d/m/Y') }}</title>
    <style>
        @page { size: A4; margin: 1.5cm; }
        body { font-family: 'Arial', sans-serif; font-size: 11pt; line-height: 1.3; color: #000; margin: 0; padding: 0; }
        .page-break { page-break-after: always; }
        
        /* Typography */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .underline-text { border-bottom: 1px solid #000; display: inline-block; padding: 0 10px; min-width: 100px; text-align: center; }
        
        /* Header */
        .header { margin-bottom: 10pt; }
        .header h1 { font-size: 13pt; margin: 0; }
        .header h2 { font-size: 11pt; margin: 4pt 0; }
        .period-line { margin: 15pt 0; }
        .thick-hr { border: none; border-top: 2px solid #000; margin-top: 5pt; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 10pt; margin-bottom: 15pt; }
        th, td { border: 1.5px solid #000; padding: 6pt 4pt; font-size: 10pt; }
        th { background-color: #fff; font-weight: bold; text-align: center; }
        .no-border, .no-border td { border: none !important; }
        
        /* Signature Section */
        .sig-container { margin-top: 30pt; width: 100%; }
        .sig-box { width: 45%; display: inline-block; text-align: center; vertical-align: top; }
        .sig-space { height: 60pt; }
        .sig-line { border-bottom: 1px solid #000; width: 80%; margin: 0 auto; min-height: 15pt; }

        /* Specific Elements */
        .meterai-box { border: 1px solid #000; padding: 15pt 5pt; width: 70pt; margin: 10pt auto; font-size: 8pt; text-align: center; }
        .doc-area { border: 2px dashed #ccc; height: 350pt; margin: 15pt 0; display: flex; align-items: center; justify-content: center; color: #999; text-align: center; }

        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="position: fixed; top: 10px; right: 10px; z-index: 100;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #000; color: #fff; cursor: pointer; border: none; font-weight: bold; border-radius: 5px;">🖨️ CETAK SEKARANG</button>
    </div>

    <!-- MAIN PAGE -->
    <div class="header text-center">
        <h1 class="font-bold">LAPORAN PERTANGGUNGJAWABAN (LPJ) 2 MINGGUAN</h1>
        <h1 class="font-bold uppercase">SATUAN PELAYANAN PEMENUHAN GIZI (SPPG) BALIMBINGAN 2</h1>
        
        <div class="period-line font-bold">
            Periode: <span class="underline-text">{{ $lpj->period_start->format('d F') }}</span> s.d. <span class="underline-text">{{ $lpj->period_end->format('d F') }}</span> 2026
        </div>
        <hr class="thick-hr">
    </div>

    <div class="section-title font-bold uppercase" style="margin-top: 15pt; border-bottom: 1px solid #ccc; padding-bottom: 2pt;">I. LAPORAN PELAKSANAAN KEGIATAN</div>
    <div class="font-bold" style="margin: 8pt 0;">1.1 Data Realisasi Penerima Manfaat</div>
    
    <table>
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
                <td>Peserta Didik (PAUD/SD/SMP/ SMA)</td>
                <td class="text-center">{{ $lpj->target_peserta }}</td>
                <td class="text-center">{{ $lpj->realisasi_peserta }}</td>
                <td>Sesuai Presensi Sekolah</td>
            </tr>
            <tr>
                <td>Pendidik & Tenaga Kependidikan</td>
                <td class="text-center">{{ $lpj->target_pendidik }}</td>
                <td class="text-center">{{ $lpj->realisasi_pendidik }}</td>
                <td>Pendamping Makan</td>
            </tr>
            <tr>
                <td>Kelompok 3B (Bumil, Busui, Balita)</td>
                <td class="text-center">{{ $lpj->target_3b }}</td>
                <td class="text-center">{{ $lpj->realisasi_3b }}</td>
                <td>Data Puskesmas/Desa</td>
            </tr>
            <tr class="font-bold">
                <td>TOTAL</td>
                <td class="text-center">{{ $lpj->target_peserta + $lpj->target_pendidik + $lpj->target_3b }}</td>
                <td class="text-center">{{ $lpj->realisasi_peserta + $lpj->realisasi_pendidik + $lpj->realisasi_3b }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title font-bold uppercase" style="margin-top: 20pt; border-bottom: 1px solid #ccc; padding-bottom: 2pt;">II. LAPORAN PENGGUNAAN DANA</div>
    <table>
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
                <td class="text-right">{{ number_format($lpj->anggaran_bahan, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($lpj->realisasi_bahan, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($lpj->anggaran_bahan - $lpj->realisasi_bahan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Operasional (Relawan, Gas, Air, Listrik)</td>
                <td class="text-right">{{ number_format($lpj->anggaran_ops, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($lpj->realisasi_ops, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($lpj->anggaran_ops - $lpj->realisasi_ops, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Insentif Fasilitas (Fixed Cost)</td>
                <td class="text-right">{{ number_format($lpj->anggaran_insentif, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($lpj->realisasi_insentif, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($lpj->anggaran_insentif - $lpj->realisasi_insentif, 0, ',', '.') }}</td>
            </tr>
            <tr class="font-bold">
                <td>TOTAL PENGELUARAN</td>
                <td class="text-right">{{ number_format($lpj->anggaran_bahan + $lpj->anggaran_ops + $lpj->anggaran_insentif, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($lpj->realisasi_bahan + $lpj->realisasi_ops + $lpj->realisasi_insentif, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format(($lpj->anggaran_bahan + $lpj->anggaran_ops + $lpj->anggaran_insentif) - ($lpj->realisasi_bahan + $lpj->realisasi_ops + $lpj->realisasi_insentif), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="sig-container">
        <div class="sig-box">
            Mengetahui,<br>
            <span class="font-bold">Ketua Yayasan</span>
            <div class="sig-space"></div>
            ( <span class="sig-line" style="display:inline-block; width:150pt;">{{ $lpj->ketua_yayasan }}</span> )
        </div>
        <div class="sig-box" style="float: right;">
            Balimbingan, <span class="sig-line" style="display:inline-block; width:80pt;">{{ $lpj->report_date->format('d F') }}</span> 2026<br>
            <span class="font-bold uppercase">Kepala SPPG Balimbingan 2</span>
            <div class="sig-space"></div>
            ( <span class="sig-line" style="display:inline-block; width:150pt;">{{ $lpj->head_sppg_nama }}</span> )
        </div>
    </div>

    <div class="page-break"></div>

    <!-- LAMPIRAN II: SPTJM -->
    <div class="section-title font-bold uppercase" style="margin-top: 10pt;">LAMPIRAN II: SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK (SPTJM)</div>
    <hr class="thick-hr">
    <p style="margin-top: 20pt;">Saya yang bertandatangan di bawah ini, Kepala SPPG Balimbingan 2, menyatakan dengan sesungguhnya bahwa:</p>
    <ol style="margin-left: 20pt; line-height: 1.8;">
        <li>Bertanggung jawab penuh atas kebenaran formil dan materiil atas penggunaan dana Bantuan Pemerintah MBG periode ini.</li>
        <li>Telah menggunakan dana sesuai peruntukan yang diatur dalam Juknis.</li>
        <li>Bersedia menyimpan seluruh bukti asli transaksi untuk keperluan audit di kemudian hari.</li>
    </ol>

    <div style="float: right; width: 200pt; text-align: center; margin-top: 40pt;">
        Balimbingan, <span class="underline-text" style="min-width: 80pt;">{{ $lpj->report_date->format('d F') }}</span> 2026
        <div class="meterai-box">
            METERAI<br>10.000
        </div>
        ( <span class="sig-line" style="display:inline-block; width:150pt;">{{ $lpj->head_sppg_nama }}</span> )<br>
        Kepala SPPG Balimbingan 2
    </div>
    <div style="clear: both;"></div>

    <div class="page-break"></div>

    <!-- LAMPIRAN IV: UJI ORGANOLEPTIK -->
    <div class="section-title font-bold uppercase">LAMPIRAN IV: UJI ORGANOLEPTIK & DOKUMENTASI</div>
    <hr class="thick-hr">
    
    <div class="font-bold" style="margin: 10pt 0;">Formulir Ringkasan Uji Organoleptik</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Sekolah / Sasaran</th>
                <th style="width: 15%;">Rasa</th>
                <th style="width: 15%;">Aroma</th>
                <th style="width: 15%;">Tekstur</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lpj->organoleptik_data ?? [] as $organo)
            <tr>
                <td>{{ $organo['sekolah'] }} <span style="border-bottom: 1px dotted #000; width: 100pt; display:inline-block;"></span></td>
                <td class="text-center">{{ $organo['rasa'] }}</td>
                <td class="text-center">{{ $organo['aroma'] }}</td>
                <td class="text-center">{{ $organo['tekstur'] }}</td>
                <td class="text-center">{{ $organo['status'] }}</td>
            </tr>
            @endforeach
            @if(empty($lpj->organoleptik_data))
                <tr><td>SDN ____________</td><td class="text-center">Layak</td><td class="text-center">Segar</td><td class="text-center">Baik</td><td class="text-center">Diterima</td></tr>
                <tr><td>SMP ____________</td><td class="text-center">Layak</td><td class="text-center">Segar</td><td class="text-center">Baik</td><td class="text-center">Diterima</td></tr>
            @endif
        </tbody>
    </table>

    <div class="font-bold" style="margin-top: 20pt;">Dokumentasi Kegiatan (Tempel Foto Open Camera Di Sini)</div>
    <div class="doc-area font-bold uppercase">
        [ AREA PENEMPELAN FOTO KEGIATAN ]<br>
        (Masak, Packing, Distribusi, dan Foto Bersama Siswa)
    </div>

</body>
</html>

