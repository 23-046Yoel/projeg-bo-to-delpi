<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-sm p-16 text-gray-900 border-t-8 border-[#0a192f] relative">
                <div class="absolute top-0 right-0 p-8">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border border-gray-200 px-4 py-2">
                        FORM LPD2M
                    </div>
                </div>

                <div class="text-center mb-12">
                    <h2 class="text-2xl font-serif font-black uppercase tracking-widest border-b-2 border-gray-900 inline-block pb-2 mb-4">LAPORAN PENGGUNA ANGGARAN (LPD2M)</h2>
                    <p class="text-sm font-bold uppercase tracking-widest">SATUAN PELAYANAN PROGRAM GIZI (SPPG)</p>
                    <p class="text-xs text-gray-500 mt-2">Periode Laporan: {{ \Carbon\Carbon::parse($date)->format('F Y') }}</p>
                </div>

                <div class="space-y-8">
                    <div class="grid grid-cols-2 gap-8 text-sm">
                        <div class="space-y-2">
                            <p><span class="w-32 inline-block font-bold">Nama SPPG</span>: SPPG DELPHI</p>
                            <p><span class="w-32 inline-block font-bold">Kode SPPG</span>: {{ auth()->user()->sppg_id ?? '001' }}</p>
                        </div>
                        <div class="space-y-2">
                            <p><span class="w-32 inline-block font-bold">Lokasi</span>: Laguboti, Sumatera Utara</p>
                            <p><span class="w-32 inline-block font-bold">Tanggal Cetak</span>: {{ now()->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <table class="w-full border-collapse border border-gray-900 text-sm">
                        <thead>
                            <tr class="bg-gray-100 uppercase font-black text-xs tracking-widest">
                                <th class="border border-gray-900 p-3 w-12">No</th>
                                <th class="border border-gray-900 p-3 text-left">Uraian Penggunaan Anggaran</th>
                                <th class="border border-gray-900 p-3 text-right">Pagu</th>
                                <th class="border border-gray-900 p-3 text-right">Realisasi</th>
                                <th class="border border-gray-900 p-3 text-right">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-900 p-3 text-center">1</td>
                                <td class="border border-gray-900 p-3">Belanja Bahan Baku (Bahan Makanan)</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-900 p-3 text-center">2</td>
                                <td class="border border-gray-900 p-3">Belanja Operasional & Penunjang</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                            </tr>
                            <tr class="font-black bg-gray-50">
                                <td colspan="2" class="border border-gray-900 p-3 text-right">TOTAL</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                                <td class="border border-gray-900 p-3 text-right">0</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-16 grid grid-cols-2 text-center text-sm font-bold">
                        <div class="space-y-20">
                            <p>DISETUJUI OLEH:<br>KEPALA SPPG</p>
                            <p>( .................................... )</p>
                        </div>
                        <div class="space-y-20">
                            <p>DIBUAT OLEH:<br>BENDAHARA</p>
                            <p>( {{ auth()->user()->name }} )</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
