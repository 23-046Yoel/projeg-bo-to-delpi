<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LPJ SPPG - {{ $lpj->period_start->format('d/m/Y') }}</title>
    <style>
        @page { size: A4; margin: 2cm; }
        body { font-family: 'Times New Roman', serif; font-size: 11pt; line-height: 1.5; color: #000; margin: 0; padding: 0; }
        .page-break { page-break-after: always; }
        .header { text-align: center; margin-bottom: 20pt; font-weight: bold; }
        .header h1 { font-size: 14pt; margin: 0; text-transform: uppercase; }
        .header h2 { font-size: 12pt; margin: 5pt 0; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 15pt; }
        th, td { border: 1px solid #000; padding: 5pt; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .center { text-align: center; }
        .right { text-align: right; }
        
        .signature-section { margin-top: 30pt; display: flex; justify-content: space-between; }
        .signature-box { width: 40%; text-align: center; }
        .signature-space { height: 60pt; }
        
        .section-title { font-weight: bold; margin-top: 15pt; margin-bottom: 5pt; }
        .no-border, .no-border td { border: none !important; }
        
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="position: fixed; top: 10px; right: 10px; z-index: 100;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #000; color: #fff; cursor: pointer; border: none; font-weight: bold; border-radius: 5px;">🖨️ CETAK SEKARANG</button>
    </div>

    <!-- MAIN REPORT -->
    <div class="header">
        <h1>LAPORAN PERTANGGUNGJAWABAN (LPJ) 2 MINGGUAN</h1>
        <h1>SATUAN PELAYANAN PEMENUHAN GIZI (SPPG) BALIMBINGAN 2</h1>
        <p>Periode: {{ $lpj->period_start->format('d F Y') }} s.d. {{ $lpj->period_end->format('d F Y') }}</p>
    </div>

    <div class="section-title">I. LAPORAN PELAKSANAAN KEGIATAN</div>
    <div style="margin-left: 20pt;">1.1 Data Realisasi Penerima Manfaat</div>
    <table>
        <thead>
            <tr>
                <th>Kategori Penerima</th>
                <th>Peserta Didik (PAUD/SD/SMP/ SMA)</th>
                <th>Pendidik & Tenaga Kependidikan</th>
                <th>Kelompok 3B (Bumil, Busui, Balita)</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Target (Jiwa)</td>
                <td class="center">{{ number_format($lpj->target_peserta) }}</td>
                <td class="center">{{ number_format($lpj->target_pendidik) }}</td>
                <td class="center">{{ number_format($lpj->target_3b) }}</td>
                <td class="center">{{ number_format($lpj->target_peserta + $lpj->target_pendidik + $lpj->target_3b) }}</td>
            </tr>
            <tr>
                <td>Realisasi (Jiwa)</td>
                <td class="center">{{ number_format($lpj->realisasi_peserta) }}</td>
                <td class="center">{{ number_format($lpj->realisasi_pendidik) }}</td>
                <td class="center">{{ number_format($lpj->realisasi_3b) }}</td>
                <td class="center">{{ number_format($lpj->realisasi_peserta + $lpj->realisasi_pendidik + $lpj->realisasi_3b) }}</td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td class="center">Sesuai Presensi Sekolah</td>
                <td class="center">Pendamping Makan</td>
                <td class="center">Data Puskesmas/Desa</td>
                <td class="center">-</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">II. LAPORAN PENGGUNAAN DANA</div>
    <table>
        <thead>
            <tr>
                <th>Uraian Komponen Biaya</th>
                <th>Anggaran (Rp)</th>
                <th>Realisasi (Rp)</th>
                <th>Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Belanja Bahan Baku (At Cost)</td>
                <td class="right">{{ number_format($lpj->anggaran_bahan) }}</td>
                <td class="right">{{ number_format($lpj->realisasi_bahan) }}</td>
                <td class="right">{{ number_format($lpj->anggaran_bahan - $lpj->realisasi_bahan) }}</td>
            </tr>
            <tr>
                <td>Biaya Operasional (Relawan, Gas, Air, Listrik)</td>
                <td class="right">{{ number_format($lpj->anggaran_ops) }}</td>
                <td class="right">{{ number_format($lpj->realisasi_ops) }}</td>
                <td class="right">{{ number_format($lpj->anggaran_ops - $lpj->realisasi_ops) }}</td>
            </tr>
            <tr>
                <td>Insentif Fasilitas (Fixed Cost)</td>
                <td class="right">{{ number_format($lpj->anggaran_insentif) }}</td>
                <td class="right">{{ number_format($lpj->realisasi_insentif) }}</td>
                <td class="right">{{ number_format($lpj->anggaran_insentif - $lpj->realisasi_insentif) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>TOTAL PENGELUARAN</td>
                <td class="right">{{ number_format($lpj->anggaran_bahan + $lpj->anggaran_ops + $lpj->anggaran_insentif) }}</td>
                <td class="right">{{ number_format($lpj->realisasi_bahan + $lpj->realisasi_ops + $lpj->realisasi_insentif) }}</td>
                <td class="right">{{ number_format(($lpj->anggaran_bahan + $lpj->anggaran_ops + $lpj->anggaran_insentif) - ($lpj->realisasi_bahan + $lpj->realisasi_ops + $lpj->realisasi_insentif)) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="no-border" style="margin-top: 40pt;">
        <tr>
            <td class="signature-box">
                Mengetahui,<br>Ketua Yayasan
                <div class="signature-space"></div>
                ( {{ $lpj->ketua_yayasan }} )
            </td>
            <td style="width: 20%;"></td>
            <td class="signature-box">
                Balimbingan, {{ $lpj->report_date->format('d F Y') }}<br>Kepala SPPG Balimbingan 2
                <div class="signature-space"></div>
                ( {{ $lpj->head_sppg_nama }} )
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- LAMPIRAN I -->
    <div class="header">
        <h1>LAMPIRAN I: BERITA ACARA SERAH TERIMA (BAST)</h1>
    </div>
    <p>Pada hari ini, ____________ Tanggal ____________ Bulan ____________ Tahun Dua Ribu Dua Puluh Enam, bertempat di SPPG Balimbingan 2, kami yang bertandatangan di bawah ini:</p>
    <p style="margin-left: 20pt;">
        1. Nama: <strong>{{ $lpj->ketua_yayasan }}</strong> (Ketua Yayasan) selaku PIHAK KESATU.<br>
        2. Nama: <strong>{{ $lpj->ppk_nama }}</strong> (PPK Badan Gizi Nasional) selaku PIHAK KEDUA.
    </p>
    <p>Menyatakan bahwa PIHAK KESATU telah menyerahkan hasil pekerjaan penyelenggaraan MBG periode {{ $lpj->period_start->format('d/m/Y') }} s.d {{ $lpj->period_end->format('d/m/Y') }} kepada PIHAK KEDUA dalam keadaan baik dan lengkap sesuai ketentuan Juknis Tata Kelola MBG TA 2026.</p>

    <table class="no-border" style="margin-top: 40pt;">
        <tr>
            <td class="signature-box">
                PIHAK KESATU
                <div class="signature-space"></div>
                ( {{ $lpj->ketua_yayasan }} )
            </td>
            <td style="width: 20%;"></td>
            <td class="signature-box">
                PIHAK KEDUA
                <div class="signature-space"></div>
                ( {{ $lpj->ppk_nama }} )
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- LAMPIRAN II -->
    <div class="header">
        <h1>LAMPIRAN II: SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK (SPTJM)</h1>
    </div>
    <p>Saya yang bertandatangan di bawah ini, Kepala SPPG Balimbingan 2, menyatakan dengan sesungguhnya bahwa:</p>
    <p>
        1. Bertanggung jawab penuh atas kebenaran formil dan materiil atas penggunaan dana Bantuan Pemerintah MBG periode ini.<br>
        2. Telah menggunakan dana sesuai peruntukan yang diatur dalam Juknis.<br>
        3. Bersedia menyimpan seluruh bukti asli transaksi untuk keperluan audit di kemudian hari.
    </p>
    
    <div style="margin-top: 40pt; float: right; width: 40%; text-align: center;">
        Balimbingan, {{ $lpj->report_date->format('d F Y') }}
        <div style="border: 1px dashed #000; padding: 10px; margin: 10pt auto; width: 80pt; font-size: 8pt;">METERAI 10.000</div>
        ( {{ $lpj->head_sppg_nama }} )<br>Kepala SPPG Balimbingan 2
    </div>
    <div style="clear: both;"></div>

    <div class="page-break"></div>

    <!-- LAMPIRAN III & IV (Simplified Templates) -->
    <div class="header">
        <h1>LAMPIRAN III: REKAPITULASI BUKU BANTU</h1>
    </div>
    <div class="section-title">A. Rekapitulasi Bahan Pangan (Harian)</div>
    <table>
        <thead>
            <tr><th>Tgl</th><th>Jenis Bahan</th><th>Volume</th><th>Satuan</th><th>Harga Satuan</th><th>Total (Rp)</th></tr>
        </thead>
        <tbody>
            <tr><td colspan="6" class="center italic" style="padding: 20pt;">Terlampir dalam Lampiran Detail / Input Manual Di Sini</td></tr>
            <tr style="font-weight: bold;"><td colspan="5" class="right">TOTAL BELANJA BAHAN</td><td class="right">{{ number_format($lpj->realisasi_bahan) }}</td></tr>
        </tbody>
    </table>

    <div class="section-title">B. Rekapitulasi Operasional & Insentif Relawan</div>
    <table>
        <thead>
            <tr><th>Tgl</th><th>Uraian Pengeluaran</th><th>Penerima / Toko</th><th>Nominal (Rp)</th></tr>
        </thead>
        <tbody>
             <tr><td colspan="4" class="center italic" style="padding: 20pt;">Terlampir dalam Lampiran Detail / Input Manual Di Sini</td></tr>
             <tr style="font-weight: bold;"><td colspan="3" class="right">TOTAL OPERASIONAL</td><td class="right">{{ number_format($lpj->realisasi_ops + $lpj->realisasi_insentif) }}</td></tr>
        </tbody>
    </table>

</body>
</html>
