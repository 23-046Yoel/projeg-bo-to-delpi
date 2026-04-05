<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAPSD - Berita Acara Penyerahan dan Serah Distribusi</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.8; margin: 3cm 2.5cm; color: #111; }
        h2 { font-size: 14pt; text-align: center; text-transform: uppercase; text-decoration: underline; }
        .center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 16pt 0; }
        th, td { border: 1px solid #000; padding: 6pt 8pt; }
        th { background: #eee; font-weight: bold; text-align: center; }
        .sig-row { display: flex; justify-content: space-around; margin-top: 48pt; text-align: center; }
        .sig-box { width: 30%; }
        .sig-space { height: 60pt; }
        @media print { .no-print { display: none; } body { margin: 2cm; } }
    </style>
</head>
<body>
    <button class="no-print" onclick="window.print()" style="position:fixed;top:20px;right:20px;background:#0a192f;color:#d4af37;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-weight:bold;">🖨️ Cetak PDF</button>

    <h2>Berita Acara Penyerahan & Serah Distribusi (BAPSD)</h2>
    <p class="center">Program Makan Bergizi Gratis (MBG)<br>
    Tanggal: {{ \Carbon\Carbon::parse($date)->format('d F Y') }} — SPPG DELPHI</p>

    <p>Pada hari ini, telah dilaksanakan penyerahan makanan bergizi gratis kepada penerima manfaat (siswa/anak prasekolah) dengan data sebagai berikut:</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Menu yang Disajikan</th>
                <th>Jumlah Porsi</th>
                <th>Satuan Penerima</th>
                <th>Ket.</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="center">1</td><td></td><td class="center"></td><td></td><td></td></tr>
            <tr><td class="center">2</td><td></td><td class="center"></td><td></td><td></td></tr>
            <tr><td class="center">3</td><td></td><td class="center"></td><td></td><td></td></tr>
        </tbody>
    </table>

    <p>Demikian Berita Acara ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <div class="sig-row">
        <div class="sig-box">
            <p>Penerima,</p>
            <div class="sig-space"></div>
            <p>( .................................... )<br>Representatif Penerima</p>
        </div>
        <div class="sig-box">
            <p>Petugas Aslap,</p>
            <div class="sig-space"></div>
            <p>( .................................... )<br>Aslap SPPG</p>
        </div>
        <div class="sig-box">
            <p>Mengetahui,<br>Kepala SPPG</p>
            <div class="sig-space"></div>
            <p>( {{ auth()->user()->name }} )</p>
        </div>
    </div>
</body>
</html>
