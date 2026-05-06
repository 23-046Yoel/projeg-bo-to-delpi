<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPJ Harian SPPG - {{ $dailyLpj->date->format('d-m-Y') }}</title>
    <style>
        @page { size: A4; margin: 2cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.3; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { font-size: 14pt; margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-weight: bold; font-size: 12pt; }
        
        h2 { font-size: 11pt; text-transform: uppercase; margin-top: 15px; margin-bottom: 5px; border-bottom: 1px solid #ccc; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; font-size: 10pt; text-transform: uppercase; }
        
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .label { font-weight: bold; display: inline-block; width: 150px; }
        
        .signatures { margin-top: 30px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; text-align: center; }
        .sig-box { height: 80px; }
        .sig-name { font-weight: bold; text-decoration: underline; }
        .sig-title { font-size: 9pt; }

        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
        }
        
        .btn-print { 
            position: fixed; top: 20px; right: 20px; padding: 10px 20px; 
            background: #000; color: #fff; border: none; border-radius: 5px; 
            cursor: pointer; font-weight: bold; text-transform: uppercase; 
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn-print no-print">Cetak Laporan</button>

    <div class="header">
        <h1>LAPORAN PERTANGGUNGJAWABAN (LPJ) HARIAN</h1>
        <p>SPPG - PROGRAM MAKAN BERGIZI GRATIS (MBG)</p>
    </div>

    <h2>IDENTITAS SPPG</h2>
    <table>
        <tr><td width="30%">Nama SPPG</td><td>{{ $dailyLpj->sppg->name }}</td></tr>
        <tr><td>Yayasan/Mitra</td><td>{{ $dailyLpj->sppg->foundation ?? 'Yayasan Pendidikan Ala Delphi' }}</td></tr>
        <tr><td>Alamat</td><td>{{ $dailyLpj->sppg->location ?? 'Kompleks SMK Ala Delphi Tiga Binanga' }}</td></tr>
        <tr><td>Kepala SPPG</td><td>{{ $dailyLpj->signatures['kepala_sppg'] ?? '-' }}</td></tr>
        <tr><td>Tanggal</td><td>{{ $dailyLpj->date->translatedFormat('d F Y') }}</td></tr>
        <tr><td>Jumlah Penerima Manfaat</td><td>{{ $dailyLpj->total_distribution }} Orang</td></tr>
    </table>

    <div class="grid">
        <div>
            <h2>RINGKASAN KEGIATAN</h2>
            <table>
                <tr><td width="60%">Total Produksi</td><td>{{ $dailyLpj->total_production }} Porsi</td></tr>
                <tr><td>Total Distribusi</td><td>{{ $dailyLpj->total_distribution }} Porsi</td></tr>
                <tr><td>Sisa Makanan</td><td>{{ $dailyLpj->leftover_food }} Porsi</td></tr>
                <tr><td>Food Waste</td><td>{{ $dailyLpj->food_waste }} Porsi</td></tr>
                <tr><td>Total Pengeluaran</td><td>Rp {{ number_format($dailyLpj->total_expenditure, 0, ',', '.') }}</td></tr>
            </table>
        </div>
        <div>
            <h2>MENU & GIZI</h2>
            <table>
                <tr><td width="50%">Karbohidrat</td><td>{{ $dailyLpj->menu->karbo }}</td></tr>
                <tr><td>Protein Hewani</td><td>{{ $dailyLpj->menu->protein_hewani }}</td></tr>
                <tr><td>Protein Nabati</td><td>{{ $dailyLpj->menu->protein_nabati }}</td></tr>
                <tr><td>Energi</td><td>{{ $dailyLpj->menu->energy ?? 0 }} kkal</td></tr>
                <tr><td>Protein</td><td>{{ $dailyLpj->menu->protein ?? 0 }} g</td></tr>
            </table>
        </div>
    </div>

    <h2>PENERIMAAN BAHAN BAKU</h2>
    <table>
        <thead>
            <tr><th>Nama Bahan</th><th>Qty</th><th>Organoleptik</th><th>Kesimpulan</th></tr>
        </thead>
        <tbody>
            @foreach($dailyLpj->material_receipts ?? [] as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ $item['organoleptic'] ?? 'Baik' }}</td>
                    <td>{{ $item['conclusion'] ?? 'Diterima' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>HACCP PRODUKSI</h2>
    <div class="grid">
        <table>
            <thead><tr><th colspan="3">Persiapan</th></tr><tr><th>Item</th><th>Hasil</th><th>Jam</th></tr></thead>
            <tbody>
                @foreach($dailyLpj->haccp_preparation ?? [] as $item)
                    <tr><td>{{ $item['material'] }}</td><td>{{ $item['qty_result'] }}</td><td>{{ $item['start_time'] }}</td></tr>
                @endforeach
            </tbody>
        </table>
        <table>
            <thead><tr><th colspan="3">Pengolahan</th></tr><tr><th>Masakan</th><th>Hasil</th><th>Jam</th></tr></thead>
            <tbody>
                @foreach($dailyLpj->haccp_processing ?? [] as $item)
                    <tr><td>{{ $item['dish'] }}</td><td>{{ $item['qty_result'] }}</td><td>{{ $item['start_time'] }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2>DISTRIBUSI</h2>
    <table>
        <thead><tr><th>Penerima Manfaat</th><th>Qty</th><th>Tiba</th><th>Organoleptik</th><th>BAST</th></tr></thead>
        <tbody>
            @foreach($dailyLpj->distribution_data ?? [] as $item)
                <tr>
                    <td>{{ $item['beneficiary'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ $item['arrival_time'] }}</td>
                    <td>{{ $item['organoleptic'] }}</td>
                    <td>{{ $item['bast'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>KEUANGAN HARIAN</h2>
    <table>
        <thead><tr><th>Keterangan</th><th style="text-align:right">Virtual</th><th style="text-align:right">Kas Kecil</th></tr></thead>
        <tbody>
            <tr><td>Saldo Awal</td><td align="right">{{ number_format($dailyLpj->initial_balance_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->initial_balance_cash, 0, ',', '.') }}</td></tr>
            <tr><td>Pengeluaran Bahan Baku</td><td align="right">{{ number_format($dailyLpj->expenditure_materials_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->expenditure_materials_cash, 0, ',', '.') }}</td></tr>
            <tr><td style="padding-left:20px">1. Gaji Relawan</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_salary_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_salary_cash, 0, ',', '.') }}</td></tr>
            <tr><td style="padding-left:20px">2. Gas</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_gas_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_gas_cash, 0, ',', '.') }}</td></tr>
            <tr><td style="padding-left:20px">3. Listrik</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_electricity_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_electricity_cash, 0, ',', '.') }}</td></tr>
            <tr><td style="padding-left:20px">4. Administrasi</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_admin_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->expenditure_ops_admin_cash, 0, ',', '.') }}</td></tr>
            <tr><td>Pengeluaran Insentif</td><td align="right">{{ number_format($dailyLpj->expenditure_incentive_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->expenditure_incentive_cash, 0, ',', '.') }}</td></tr>
            <tr style="font-weight:bold"><td>Saldo Akhir</td><td align="right">{{ number_format($dailyLpj->final_balance_virtual, 0, ',', '.') }}</td><td align="right">{{ number_format($dailyLpj->final_balance_cash, 0, ',', '.') }}</td></tr>
        </tbody>
    </table>

    <h2>KESIMPULAN HARIAN</h2>
    <p style="border: 1px solid #000; padding: 10px; min-height: 50px;">{{ $dailyLpj->conclusion }}</p>

    <div class="signatures">
        <div>
            <div class="sig-title">Kepala SPPG</div>
            <div class="sig-box"></div>
            <div class="sig-name">{{ $dailyLpj->signatures['kepala_sppg'] }}</div>
        </div>
        <div>
            <div class="sig-title">Pengawas Gizi</div>
            <div class="sig-box"></div>
            <div class="sig-name">{{ $dailyLpj->signatures['pengawas_gizi'] }}</div>
        </div>
        <div>
            <div class="sig-title">Pengawas Keuangan</div>
            <div class="sig-box"></div>
            <div class="sig-name">{{ $dailyLpj->signatures['pengawas_keuangan'] }}</div>
        </div>
        <div>
            <div class="sig-title">Asisten Lapangan</div>
            <div class="sig-box"></div>
            <div class="sig-name">{{ $dailyLpj->signatures['asisten_lapangan'] }}</div>
        </div>
        <div>
            <div class="sig-title">Perwakilan Yayasan</div>
            <div class="sig-box"></div>
            <div class="sig-name">{{ $dailyLpj->signatures['perwakilan_yayasan'] }}</div>
        </div>
    </div>
</body>
</html>
