<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">
            {{ __('Surat Pernyataan Tanggung Jawab') }}
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
        <div class="max-w-[800px] mx-auto bg-white p-[60px] shadow-2xl border border-gray-100 print:shadow-none print:p-0 print:border-none font-serif text-[#1e293b]">
            <!-- Heading -->
            <div class="text-center mb-8">
                <p class="text-[12px] font-medium mb-4" contenteditable="true">Kop surat Yayasan</p>
                <div class="border-t-4 border-double border-black w-full mb-8"></div>
                <div class="relative">
                    <h1 class="text-[18px] font-black tracking-[0.1em] border-b-2 border-black inline-block px-4 mb-8" contenteditable="true">SURAT PERNYATAAN TANGGUNG JAWAB</h1>
                    <div class="absolute top-[-40px] right-0">
                        <div class="w-10 h-10 border-2 border-[#1e293b] flex items-center justify-center p-1">
                            <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 text-[14px] leading-[1.8]">
                <p contenteditable="true">Saya yang bertanda tangan di bawah ini:</p>

                <div class="grid grid-cols-[100px_auto] gap-y-1 ml-4 italic">
                    <div class="font-bold">Nama</div><div contenteditable="true" id="field-nama">: {{ $data['nama'] }}</div>
                    <div class="font-bold">Jabatan</div><div contenteditable="true" id="field-jabatan">: {{ $data['jabatan'] }}</div>
                </div>

                <div class="text-justify" contenteditable="true">
                    menyatakan bertanggung jawab secara formal dan material atas penerimaan dan pengeluaran dana yang dilaksanakan dengan menggunakan dana APBN TA 2026 melalui DIPA Badan Gizi Nasional TA 2026, dengan mata anggaran sebagai Bantuan Pemerintah untuk Program Makan Bergizi Gratis. Sebagaimana Surat Pernyataan Tanggung Jawab penggunaan anggaran <span class="font-black">Bahan Baku/Operasional/Insentif Fasilitas</span> beserta bukti-bukti pengeluaran yang sah dengan rincian:
                </div>

                <!-- Data Table -->
                <div class="max-w-md ml-4 space-y-2 py-4">
                    <div class="grid grid-cols-[150px_20px_auto] items-center">
                        <div contenteditable="true">1. Jumlah Penerimaan</div><div class="text-center">:</div><div class="font-bold" contenteditable="true">{{ number_format($data['penerimaan']) }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_20px_auto] items-center">
                        <div contenteditable="true">2. Jumlah Pengeluaran</div><div class="text-center">:</div><div class="font-bold border-b border-black" contenteditable="true">{{ number_format($data['pengeluaran']) }}</div>
                    </div>
                    <div class="grid grid-cols-[150px_20px_auto] items-center">
                        <div class="font-black" contenteditable="true">3. Sisa Dana</div><div class="text-center">:</div><div class="font-black underline border-b-4 border-double border-black" contenteditable="true">{{ number_format($data['sisa']) }}</div>
                    </div>
                </div>

                <p class="text-justify" contenteditable="true">
                    Demikian surat ini saya buat untuk dapat dipergunakan sebagaimana mestinya dan untuk dapat dipertanggungjawabkan.
                </p>

                <!-- Signatures -->
                <div class="pt-8 flex flex-col items-end text-center uppercase">
                    <div class="w-80">
                        <p class="text-[12px] normal-case italic" contenteditable="true" id="field-waktu">{{ $data['lokasi'] }}, {{ $data['tanggal'] }}</p>
                        <p class="text-[13px] font-black mb-24" contenteditable="true">{{ $data['jabatan'] }}</p>
                        
                        <p class="text-[14px] font-extrabold border-b-2 border-black inline-block px-10" contenteditable="true">{{ $data['nama'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    <!-- Print Button -->
                    <div class="mt-20 text-center no-print">
                        <button onclick="window.print()" class="px-10 py-4 bg-royal-navy text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl hover:bg-gold transition-all transform hover:-translate-y-1 active:scale-95">
                            Cetak Surat Pertanggungjawaban
                        </button>
                    </div>
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
            .p-16 { padding: 0 !important; }
        }
    </style>
    <script>
        function saveReport() {
            const btn = document.getElementById('saveBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';

            const data = {
                nama: document.getElementById('field-nama').innerText.replace(': ', ''),
                jabatan: document.getElementById('field-jabatan').innerText.replace(': ', ''),
                lokasi: document.getElementById('field-waktu').innerText.split(', ')[0],
                tanggal: document.getElementById('field-waktu').innerText.split(', ')[1]
            };

            fetch('{{ route('reports.save') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    type: 'sptj',
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
