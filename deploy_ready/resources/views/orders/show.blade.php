<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pesanan #SP{{ $order->id }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.8; margin: 3cm 2.5cm; color: #111; }
        .letterhead { display: flex; align-items: center; border-bottom: 3px solid #000; padding-bottom: 12pt; margin-bottom: 24pt; gap: 20px; }
        .letterhead-text h1 { font-size: 14pt; text-transform: uppercase; margin: 0; }
        .letterhead-text p { font-size: 9pt; margin: 0; }
        h2 { font-size: 14pt; text-align: center; text-decoration: underline; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin: 16pt 0; }
        th, td { border: 1px solid #000; padding: 6pt 8pt; }
        th { background: #eee; font-weight: bold; text-align: center; }
        .no-number { list-style: none; padding: 0; }
        .no-number li span { display: inline-block; width: 160px; }
        .sig { margin-top: 48pt; text-align: right; }
        .sig-space { height: 72pt; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="position:fixed;top:20px;right:20px;display:flex;gap:10px;">
        @if($order->status == 'pending')
            <form action="{{ route('orders.receive', $order) }}" method="POST">
                @csrf
                <button type="submit" style="background:#22c55e;color:white;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-weight:bold;">✅ Terima Barang</button>
            </form>
        @else
            <button style="background:#94a3b8;color:white;border:none;padding:10px 20px;border-radius:8px;cursor:not-allowed;font-weight:bold;">📦 Sudah Diterima</button>
        @endif
        <button onclick="window.print()" style="background:#0a192f;color:#d4af37;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-weight:bold;">🖨️ Cetak Surat</button>
    </div>

    <div class="letterhead">
        <div class="letterhead-text">
            <h1>SPPG Delphi</h1>
            <p>Program Makan Bergizi Gratis (MBG)</p>
            <p>Laguboti, Sumatera Utara</p>
        </div>
    </div>

    <h2>Surat Pesanan / Purchase Order</h2>
    <p style="text-align:center">No: SP/{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}/{{ \Carbon\Carbon::parse($order->order_date)->format('mY') }}</p>

    <ul class="no-number">
        <li><span>Kepada Yth.</span>: {{ $order->supplier->name }}</li>
        <li><span>Alamat Supplier</span>: {{ $order->supplier->address ?? '-' }}</li>
        <li><span>Tanggal Pesan</span>: {{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}</li>
    </ul>

    <p>Dengan hormat, kami bermaksud memesan bahan-bahan makanan sebagaimana tertera di bawah ini untuk keperluan program MBG:</p>

    <table>
        <thead>
            <tr>
                <th style="width:40px">No</th>
                <th>Nama Bahan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($order->items as $idx => $item)
            @php $subtotal = $item->requested_quantity * ($item->price); $total += $subtotal; @endphp
            <tr>
                <td style="text-align:center">{{ $idx + 1 }}</td>
                <td>{{ $item->material->name ?? '-' }}</td>
                <td style="text-align:right">{{ number_format($item->requested_quantity, 2) }}</td>
                <td style="text-align:center">{{ $item->unit }}</td>
                <td style="text-align:right">Rp {{ number_format($item->price) }}</td>
                <td style="text-align:right">Rp {{ number_format($subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;font-weight:bold">TOTAL</td>
                <td style="text-align:right;font-weight:bold">Rp {{ number_format($total) }}</td>
            </tr>
        </tfoot>
    </table>

    <p>Mohon kiranya bahan-bahan di atas dapat dikirimkan ke lokasi SPPG Delphi. Terima kasih atas kerja sama yang baik.</p>

    <div class="sig">
        <p>{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }},<br>Kepala SPPG Delphi</p>
        <div class="sig-space"></div>
        <p>( {{ auth()->user()->name }} )</p>
    </div>
</body>
</html>
