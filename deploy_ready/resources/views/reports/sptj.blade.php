<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPTJ - Surat Pernyataan Tanggung Jawab</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.8; margin: 3cm 2.5cm; color: #111; }
        h2 { font-size: 14pt; text-align: center; text-transform: uppercase; text-decoration: underline; margin-bottom: 6pt; }
        .center { text-align: center; }
        .sub { font-size: 11pt; text-align: center; margin-bottom: 24pt; }
        p { margin-bottom: 8pt; text-align: justify; }
        .signature-block { margin-top: 48pt; display: flex; justify-content: space-between; }
        .sig { text-align: center; width: 45%; }
        .sig-space { height: 72pt; }
        table { width: 100%; border-collapse: collapse; margin: 16pt 0; }
        th, td { border: 1px solid #000; padding: 6pt 8pt; }
        th { background: #eee; font-weight: bold; text-align: center; }
        @media print { .no-print { display: none; } body { margin: 2cm; } }
    </style>
</head>
<body>
    <button class="no-print" onclick="window.print()" style="position:fixed;top:20px;right:20px;background:#0a192f;color:#d4af37;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-weight:bold;">🖨️ Cetak PDF</button>

    <h2>Surat Pernyataan Tanggung Jawab (SPTJ)</h2>
    <p class="sub">Program Makan Bergizi Gratis (MBG) — SPPG DELPHI<br>
    Periode: {{ \Carbon\Carbon::parse($date)->format('F Y') }}</p>

    <p>Yang bertanda tangan di bawah ini:</p>

    <table>
        <tr><td width="200">Nama</td><td>: {{ auth()->user()->name }}</td></tr>
        <tr><td>Jabatan</td><td>: Kepala SPPG / Penanggung Jawab</td></tr>
        <tr><td>Nama SPPG</td><td>: SPPG DELPHI</td></tr>
        <tr><td>Lokasi</td><td>: Laguboti, Sumatera Utara</td></tr>
    </table>

    <p>Dengan ini menyatakan bahwa:</p>
    <ol>
        <li>Seluruh anggaran program MBG yang tercantum dalam dokumen Rencana Kegiatan dan Anggaran (RKA) SPPG telah digunakan secara efisien, efektif, dan ekonomis sesuai dengan peruntukannya.</li>
        <li>Bukti-bukti pengeluaran yang sah atas penggunaan anggaran pada periode laporan tersebut di atas tersimpan dengan baik dan dapat dipergunakan sewaktu-waktu untuk keperluan pemeriksaan.</li>
        <li>Apabila di kemudian hari ditemukan ketidaksesuaian atau penyimpangan dalam penggunaan anggaran, saya bertanggung jawab penuh dan bersedia menerima sanksi sesuai peraturan yang berlaku.</li>
    </ol>

    <p>Demikian surat pernyataan ini dibuat dengan sebenar-benarnya.</p>

    <div class="signature-block">
        <div class="sig">
            <p>Mengetahui,<br>Kepala Yayasan</p>
            <div class="sig-space"></div>
            <p>( .................................... )<br>NIP/NIK: .........................</p>
        </div>
        <div class="sig">
            <p>{{ \Carbon\Carbon::parse($date)->format('d F Y') }},<br>Yang Membuat Pernyataan,</p>
            <div class="sig-space"></div>
            <p>( {{ auth()->user()->name }} )<br>Kepala SPPG</p>
        </div>
    </div>
</body>
</html>
