<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            {{ __('Laporan Penggunaan Dana Dua Pekanan') }}
        </h2>
    </x-slot>

    <div class="py-12 no-print">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p class="text-sm font-bold text-blue-800 italic">Mode Edit Aktif: Bapak bisa langsung klik dan ketik pada teks di bawah untuk mengubah isinya.</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="saveReport()" id="saveBtn" class="px-6 py-2 bg-emerald-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all flex items-center">
                        Simpan Perubahan
                    </button>
                    <button onclick="window.print()" class="px-6 py-2 bg-royal-navy text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-gold transition-all">Cetak Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-24">
        <div class="max-w-[800px] mx-auto bg-white p-[50px] shadow-2xl border border-gray-100 print:shadow-none print:p-0 print:border-none font-serif text-[#1e293b]">
            <!-- Document Header -->
            <div class="text-center mb-4">
                <p class="text-[12px] font-medium mb-4" contenteditable="true">Kop surat SPPG</p>
                <div class="border-t-4 border-double border-black w-full mb-6"></div>
                <div class="relative">
                    <h1 class="text-[18px] font-black tracking-tight mb-1" contenteditable="true">LAPORAN PENGGUNAAN DANA DUA PEKANAN</h1>
                    <p class="text-[14px] font-bold" contenteditable="true">Periode : {{ $data['period'] }}</p>
                    <div class="absolute top-0 right-0">
                        <div class="w-10 h-10 border-2 border-[#1e293b] flex items-center justify-center p-1">
                            <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 text-[13px]">
                <p contenteditable="true">Yang bertanda tangan di bawah ini:</p>
                <div class="grid grid-cols-[120px_auto] gap-y-1 ml-4">
                    <div class="font-bold">Nama</div><div contenteditable="true" id="field-user-name">: {{ $data['user_name'] }}</div>
                    <div class="font-bold">Jabatan</div><div contenteditable="true" id="field-jabatan">: {{ $data['jabatan'] }}</div>
                    <div class="font-bold">Yayasan</div><div contenteditable="true" id="field-yayasan">: {{ $data['yayasan'] }}</div>
                    <div class="font-bold">SPPG</div><div contenteditable="true" id="field-sppg-name">: {{ $data['sppg_name'] }}</div>
                    <div class="font-bold">ID SPPG</div><div contenteditable="true" id="field-sppg-id">: {{ $data['sppg_id'] }}</div>
                </div>

                <p contenteditable="true" class="mt-4">Dengan ini menyatakan bahwa laporan penggunaan dana sebagai berikut:</p>

                <div class="space-y-4">
                    <h2 class="font-black" contenteditable="true">I. RINCIAN KEUANGAN (ANGGARAN)</h2>
                    
                    <div class="space-y-1 mb-4">
                        <div class="grid grid-cols-[auto_150px_auto] gap-x-2 items-center">
                            <div class="font-bold">1. Anggaran Bahan Baku</div>
                            <div class="font-black text-right border-b-2 border-black" contenteditable="true" id="field-budget-bahan">{{ number_format($data['budget_bahan_periode']) }}</div>
                            <div class="italic text-[11px]" contenteditable="true">({{ $data['porsi_besar'] }} P.Besar, {{ $data['porsi_kecil'] }} P.Kecil)</div>
                        </div>
                        <div class="grid grid-cols-[auto_150px_auto] gap-x-2 items-center">
                            <div class="font-bold">2. Anggaran Operasional</div>
                            <div class="font-black text-right border-b-2 border-black" contenteditable="true" id="field-budget-ops">{{ number_format($data['budget_ops_periode']) }}</div>
                            <div class="italic text-[11px]" contenteditable="true">(Rp 3.000 x {{ $data['porsi_besar'] + $data['porsi_kecil'] }} porsi x 12 hari)</div>
                        </div>
                    </div>

                    <div class="space-y-1 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h3 class="font-bold underline italic mb-2">Realisasi Belanja (Aktual)</h3>
                        <div class="grid grid-cols-[auto_150px] gap-x-2 ml-4">
                            <div>Bahan Baku</div><div class="text-right border-b border-gray-300" contenteditable="true" id="field-belanja-bahan">{{ number_format($data['belanja_bahan']) }}</div>
                            <div>Operasional</div><div class="text-right border-b border-gray-300" contenteditable="true" id="field-operasional">{{ number_format($data['operasional']) }}</div>
                            <div>Insentif Fasilitas</div><div class="text-right border-b border-gray-300" contenteditable="true" id="field-insentif">{{ number_format($data['insentif']) }}</div>
                        </div>
                        <div class="grid grid-cols-[auto_150px] gap-x-2 border-t-2 border-black pt-1 mt-2">
                            <div class="font-black">Total Realisasi Belanja</div>
                            <div class="font-black text-right border-b-4 border-double border-black underline" contenteditable="true" id="field-total-belanja">{{ number_format($data['belanja_bahan'] + $data['operasional'] + $data['insentif']) }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-[auto_150px] gap-x-2 pt-4">
                        <div class="font-black text-lg">SISA ANGGARAN PERIODE</div>
                        <div class="font-black text-lg text-right border-b-4 border-double border-black bg-yellow-50" contenteditable="true" id="field-sisa-dana">{{ number_format($data['sisa_dana']) }}</div>
                    </div>
                    <p class="text-[10px] italic text-gray-500">* Sisa Anggaran = (Total Anggaran) - (Total Realisasi Belanja)</p>
                </div>

                <div class="space-y-4">
                    <h2 class="font-black" contenteditable="true">II. RINCIAN KETERANGAN</h2>
                    <p contenteditable="true">Dana yang telah digunakan sesuai dengan kebutuhan kegiatan yang telah direncanakan, dengan rincian pemakaian bahan baku sebagai berikut:</p>
                    
                    <!-- New Materials Qty Table -->
                    <div class="border border-black overflow-hidden rounded-lg">
                        <table class="w-full text-left text-[11px]">
                            <thead class="bg-gray-50 border-b border-black">
                                <tr>
                                    <th class="px-3 py-2 font-black border-r border-black w-12 text-center">No</th>
                                    <th class="px-3 py-2 font-black border-r border-black">Nama Bahan Baku</th>
                                    <th class="px-3 py-2 font-black text-right">Volume / Qty</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-black">
                                @forelse($data['usages'] ?? [] as $index => $usage)
                                    <tr>
                                        <td class="px-3 py-2 border-r border-black text-center">{{ $index + 1 }}</td>
                                        <td class="px-3 py-2 border-r border-black font-bold uppercase">{{ $usage->material->name }}</td>
                                        <td class="px-3 py-2 text-right font-black">{{ number_format($usage->total_qty, 2) }} <span class="text-[9px]">{{ $usage->material->unit }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-3 py-4 text-center italic text-gray-400">Belum ada pemakaian bahan terekam pada periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-[150px_auto] gap-y-1 ml-4 mt-4">
                        <div class="font-bold italic">Rekening Operasional</div><div contenteditable="true">: {{ $data['virtual_account'] }}</div>
                        <div class="font-bold italic">Keterangan Tambahan</div><div contenteditable="true">: Pemakaian bahan baku di atas adalah alokasi untuk operasional harian SPPG sesuai menu yang dijalankan.</div>
                    </div>
                </div>

                <p contenteditable="true" class="mt-4">
                    Sisa dana sebesar Rp {{ number_format($data['sisa_dana']) }},- akan dialihkan ke periode selanjutnya.<br>
                    Pengalihan sisa dana ini bertujuan untuk mendukung kegiatan yang telah direncanakan.
                </p>

                <div class="grid grid-cols-2 gap-x-12 pt-10 text-center">
                    <div class="space-y-24">
                        <p contenteditable="true">Pihak Pertama,<br>PENDIDIKAN ALA DELPHI</p>
                        <p class="font-black underline uppercase" contenteditable="true">{{ $data['pimpinan'] }}</p>
                        <p class="text-[11px]" contenteditable="true">Ketua/Mewakili</p>
                    </div>
                    <div class="space-y-20">
                        <p contenteditable="true">BALIMBINGAN, 18 April 2026<br>Pihak Kedua,<br>Staf Pengawas Keuangan<br>SPPG BALIMBINGAN 2</p>
                        <p class="font-black underline uppercase" contenteditable="true">{{ $data['bendahara'] }}</p>
                        <p class="text-[11px]" contenteditable="true">AGITA SEBAYANG</p>
                    </div>
                </div>

                <div class="text-center pt-8 space-y-20">
                    <p contenteditable="true">Mengetahui,<br>Kepala SPPG BALIMBINGAN 2</p>
                    <p class="font-black underline uppercase" contenteditable="true">{{ $data['ka_sppg'] }}</p>
                    <p class="text-[11px]" contenteditable="true">ABDI SEPTIAN</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .shadow-2xl { shadow: none !important; }
            .bg-silk { background: #f8fafc !important; }
        }
    </style>
    <script>
        function saveReport() {
            const btn = document.getElementById('saveBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';

            const data = {
                period: '{{ $data['period'] }}',
                user_name: document.getElementById('field-user-name').innerText.replace(': ', ''),
                jabatan: document.getElementById('field-jabatan').innerText.replace(': ', ''),
                yayasan: document.getElementById('field-yayasan').innerText.replace(': ', ''),
                sppg_name: document.getElementById('field-sppg-name').innerText.replace(': ', ''),
                sppg_id: document.getElementById('field-sppg-id').innerText.replace(': ', ''),
                dana_masuk: parseInt(document.getElementById('field-dana-masuk').innerText.replace(/,/g, '')),
                belanja_bahan: parseInt(document.getElementById('field-belanja-bahan').innerText.replace(/,/g, '')),
                operasional: parseInt(document.getElementById('field-operasional').innerText.replace(/,/g, '')),
                insentif: parseInt(document.getElementById('field-insentif').innerText.replace(/,/g, '')),
                sisa_dana: parseInt(document.getElementById('field-sisa-dana').innerText.replace(/,/g, '')),
                virtual_account: '{{ $data['virtual_account'] }}'
            };

            fetch('{{ route('reports.save') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    type: 'lpd2m',
                    data: data
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) alert(result.message);
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }
    </script>
</x-app-layout>
