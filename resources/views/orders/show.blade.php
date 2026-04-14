<x-app-layout>
    <style>
        @media print {
            body * { visibility: hidden; }
            #printable, #printable * { visibility: visible; }
            #printable { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>

    <div class="py-8 bg-gray-100 min-h-screen print:bg-white print:py-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Action Buttons (hidden on print) -->
            <div class="no-print flex justify-end space-x-3 mb-4">
                <a href="{{ route('orders.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-royal-navy font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:bg-gray-50 transition-all">
                    ← Kembali
                </a>
                <button onclick="window.print()" class="px-6 py-3 bg-royal-navy text-gold font-black text-[10px] uppercase tracking-[0.3em] rounded-2xl shadow-xl hover:-translate-y-1 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak PO
                </button>
                @if($order->status === 'pending')
                <form action="{{ route('orders.receive', $order) }}" method="POST" onsubmit="return confirm('Tandai pesanan ini sudah diterima?')">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:bg-emerald-700 transition-all">
                        ✓ Terima Barang
                    </button>
                </form>
                @endif
            </div>

            <!-- PRINTABLE DOCUMENT -->
            <div id="printable" class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100 print:shadow-none print:border-none print:rounded-none">

                <!-- ===== KOP SURAT / LETTERHEAD ===== -->
                <div class="border-b-4 border-royal-navy">
                    <div class="flex items-center justify-between px-10 pt-8 pb-6">
                        <!-- Logo BGN (Kiri) -->
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16 rounded-full bg-royal-navy flex items-center justify-center shadow-lg">
                                <svg class="w-9 h-9 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight">Badan Gizi Nasional</p>
                                <p class="text-[9px] font-bold text-gray-400 tracking-wide">National Nutrition Agency</p>
                            </div>
                        </div>

                        <!-- Judul Tengah -->
                        <div class="text-center flex-1 px-4">
                            <h1 class="text-lg font-black text-royal-navy uppercase tracking-widest">SPPG {{ $order->sppg->name ?? (auth()->user()->sppg->name ?? 'ALAD ELPHI') }}</h1>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.15em] mt-0.5">Satuan Pelayanan Pemenuhan Gizi</p>
                            <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Program Makan Bergizi Gratis (MBG)</p>
                        </div>

                        <!-- Logo Yayasan (Kanan) -->
                        <div class="flex items-center space-x-3">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight text-right">Yayasan Alad Elphi</p>
                                <p class="text-[9px] font-bold text-gray-400 tracking-wide text-right">Foundation</p>
                            </div>
                            <div class="w-16 h-16 rounded-full bg-gold flex items-center justify-center shadow-lg">
                                <svg class="w-9 h-9 text-royal-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-header strip -->
                    <div class="bg-royal-navy px-10 py-2 flex justify-between items-center">
                        <p class="text-[9px] font-bold text-gold/80 uppercase tracking-widest">Surat Pesanan / Purchase Order</p>
                        <p class="text-[9px] font-bold text-gold/80 uppercase tracking-widest">No: #SP{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <!-- ===== INFO GRID ===== -->
                <div class="grid grid-cols-2 gap-0 border-b border-gray-100">
                    <div class="p-8 border-r border-gray-100">
                        <h3 class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Kepada Yth. (Supplier)</h3>
                        <p class="text-base font-black text-royal-navy mb-1">{{ $order->supplier->name }}</p>
                        <p class="text-xs text-gray-500 font-medium">{{ $order->supplier->address ?? '-' }}</p>
                        <p class="text-xs text-gray-500 font-medium">Telp: {{ $order->supplier->phone ?? '-' }}</p>
                    </div>
                    <div class="p-8">
                        <h3 class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Detail Pesanan</h3>
                        <table class="w-full text-xs">
                            <tr>
                                <td class="py-1 font-bold text-gray-500 w-32 uppercase tracking-wider">Tanggal</td>
                                <td class="py-1 font-black text-royal-navy">{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 font-bold text-gray-500 uppercase tracking-wider">No. PO</td>
                                <td class="py-1 font-black text-royal-navy">#SP{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 font-bold text-gray-500 uppercase tracking-wider">Dapur</td>
                                <td class="py-1 font-black text-royal-navy">{{ $order->sppg->name ?? (auth()->user()->sppg->name ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 font-bold text-gray-500 uppercase tracking-wider">Status</td>
                                <td class="py-1">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase
                                        {{ $order->status === 'received' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $order->status === 'received' ? 'Diterima' : 'Menunggu' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- ===== ITEMS TABLE ===== -->
                <div class="p-10">
                    <table class="w-full mb-10">
                        <thead>
                            <tr class="bg-royal-navy/5">
                                <th class="px-4 py-3 text-left text-[9px] font-black text-royal-navy uppercase tracking-widest rounded-l-xl">No.</th>
                                <th class="px-4 py-3 text-left text-[9px] font-black text-royal-navy uppercase tracking-widest">Nama Bahan Baku</th>
                                <th class="px-4 py-3 text-center text-[9px] font-black text-royal-navy uppercase tracking-widest">Jumlah</th>
                                <th class="px-4 py-3 text-center text-[9px] font-black text-royal-navy uppercase tracking-widest">Satuan</th>
                                <th class="px-4 py-3 text-right text-[9px] font-black text-royal-navy uppercase tracking-widest">Harga Satuan</th>
                                <th class="px-4 py-3 text-right text-[9px] font-black text-royal-navy uppercase tracking-widest rounded-r-xl">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->items as $idx => $item)
                            <tr>
                                <td class="px-4 py-4 text-xs text-gray-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-black text-royal-navy">{{ $item->material->name }}</p>
                                </td>
                                <td class="px-4 py-4 text-center text-sm font-black text-royal-navy">
                                    {{ number_format($item->requested_quantity, 2) }}
                                </td>
                                <td class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase">
                                    {{ $item->unit }}
                                </td>
                                <td class="px-4 py-4 text-right text-xs font-medium text-gray-600">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-sm font-black text-royal-navy">
                                    Rp {{ number_format($item->requested_quantity * $item->price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-royal-navy/20">
                                <td colspan="5" class="px-4 py-5 text-right text-[10px] font-black text-royal-navy uppercase tracking-[0.2em]">Total Nilai Pesanan</td>
                                <td class="px-4 py-5 text-right text-xl font-black text-royal-navy">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- ===== CATATAN ===== -->
                    <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5 mb-10">
                        <p class="text-[9px] font-black text-amber-700 uppercase tracking-widest mb-1">Catatan & Instruksi Pengiriman</p>
                        <p class="text-xs text-amber-800 font-medium leading-relaxed">
                            Sesuai dengan petunjuk teknis Badan Gizi Nasional (BGN), harap kirimkan bahan baku tepat waktu dengan kualitas terbaik dan standar kebersihan pangan.
                            Sertakan invoice/faktur saat pengiriman. Barang wajib diperiksa oleh petugas Quality Control (QC) sebelum diterima.
                        </p>
                    </div>

                    <!-- ===== TANDA TANGAN SPESIMEN ===== -->
                    <div class="grid grid-cols-3 gap-8 mt-4">
                        <!-- Penerima / Supplier -->
                        <div class="text-center">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-16">Supplier</p>
                            <div class="w-full h-px bg-gray-300 mb-2"></div>
                            <p class="text-xs font-black text-royal-navy uppercase">{{ $order->supplier->name }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Pihak Supplier</p>
                        </div>

                        <!-- Kepala Dapur -->
                        @php
                            $sppgId = $order->sppg_id ?? auth()->user()->sppg_id;
                            $kepalaDapur = \App\Models\User::where('sppg_id', $sppgId)
                                ->where('role', \App\Models\User::ROLE_KA_SPPG)
                                ->first();
                        @endphp
                        <div class="text-center">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Mengetahui,</p>
                            @if($kepalaDapur && $kepalaDapur->signature_path)
                                <img src="{{ asset('storage/' . $kepalaDapur->signature_path) }}"
                                     alt="TTD Kepala Dapur"
                                     class="h-16 mx-auto object-contain mb-1">
                            @else
                                <div class="h-16"></div>
                            @endif
                            <div class="w-full h-px bg-gray-300 mb-2"></div>
                            <p class="text-xs font-black text-royal-navy uppercase">{{ $kepalaDapur->name ?? '( _______________ )' }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Kepala Dapur SPPG</p>
                        </div>

                        <!-- Keuangan -->
                        @php
                            $keuangan = \App\Models\User::where('sppg_id', $sppgId)
                                ->where('role', \App\Models\User::ROLE_PENGAWAS_KEUANGAN)
                                ->first();
                        @endphp
                        <div class="text-center">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Pengawas Keuangan,</p>
                            @if($keuangan && $keuangan->signature_path)
                                <img src="{{ asset('storage/' . $keuangan->signature_path) }}"
                                     alt="TTD Keuangan"
                                     class="h-16 mx-auto object-contain mb-1 mt-1">
                            @else
                                <div class="h-14"></div>
                            @endif
                            <div class="w-full h-px bg-gray-300 mb-2"></div>
                            <p class="text-xs font-black text-royal-navy uppercase">{{ $keuangan->name ?? '( _______________ )' }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Pengawas Keuangan</p>
                        </div>
                    </div>
                </div>

                <!-- Footer strip -->
                <div class="bg-royal-navy/5 px-10 py-4 border-t border-gray-100 flex justify-between items-center">
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Dokumen ini dibuat secara digital melalui sistem Bo To Delpi</p>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>

            </div><!-- end #printable -->
        </div>
    </div>
</x-app-layout>
