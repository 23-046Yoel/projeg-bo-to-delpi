<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen print:bg-white print:py-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter & Action Card -->
            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100 mb-8 print:hidden">
                <div class="p-8 md:p-10">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div>
                            <h2 class="text-2xl font-black text-royal-navy uppercase tracking-tight">Rekap Pesanan Harian</h2>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Berdasarkan Perencanaan Menu harian</p>
                        </div>
                        <form action="{{ route('orders.daily') }}" method="GET" class="flex items-center gap-4 bg-silk p-3 rounded-2xl">
                            <input type="date" name="date" value="{{ $date }}" 
                                class="bg-transparent border-none text-sm font-black text-royal-navy focus:ring-0 outline-none">
                            <button type="submit" class="bg-royal-navy text-gold px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy/90 transition-all">
                                Filter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Document -->
            <div class="bg-white shadow-2xl rounded-none md:rounded-[3rem] overflow-hidden border border-gray-100 print:shadow-none print:border-none">
                
                <x-letterhead 
                    title="Rekap Kebutuhan Bahan Harian" 
                    subtitle="Daily Requirement Recap"
                    :sppgName="auth()->user()->sppg->name ?? 'Unit SPPG'"
                />

                <!-- Content Body -->
                <div class="p-8 md:p-12">
                    @if(count($requirements) > 0)
                        <table class="w-full mb-12">
                            <thead>
                                <tr class="border-b-2 border-royal-navy/10">
                                    <th class="py-5 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Nama Bahan Baku</th>
                                    <th class="py-5 text-center text-[10px] font-black text-royal-navy uppercase tracking-widest">Total Kebutuhan</th>
                                    <th class="py-5 text-right text-[10px] font-black text-royal-navy uppercase tracking-widest">Estimasi Harga</th>
                                    <th class="py-5 text-right text-[10px] font-black text-royal-navy uppercase tracking-widest">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @php $grandTotal = 0; @endphp
                                @foreach($requirements as $item)
                                    @php 
                                        $subtotal = $item['total'] * $item['price'];
                                        $grandTotal += $subtotal;
                                    @endphp
                                    <tr class="group hover:bg-gold/5 transition-colors">
                                        <td class="py-6">
                                            <p class="font-black text-royal-navy">{{ $item['name'] }}</p>
                                            <p class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">Komponen Resep MBG</p>
                                        </td>
                                        <td class="py-6 text-center">
                                            <span class="font-black text-royal-navy">{{ number_format($item['total'], 2) }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase ml-1">{{ $item['unit'] }}</span>
                                        </td>
                                        <td class="py-6 text-right text-gray-500 font-medium">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </td>
                                        <td class="py-6 text-right font-black text-royal-navy">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-royal-navy pt-8">
                                    <td colspan="3" class="py-10 text-right text-[11px] font-black text-royal-navy uppercase tracking-[0.3em]">Total Estimasi Biaya Hari Ini</td>
                                    <td class="py-10 text-right text-2xl font-black text-royal-navy">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Action for generating formal Order -->
                        <div class="print:hidden flex justify-between items-center bg-silk p-8 rounded-3xl border-2 border-dashed border-gray-200">
                            <div>
                                <h4 class="text-sm font-black text-royal-navy uppercase">Konversi ke Surat Pesanan</h4>
                                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">Gunakan data di atas untuk membuat PO resmi ke Supplier</p>
                            </div>
                            <a href="{{ route('orders.create', ['start_date' => $date, 'end_date' => $date]) }}" 
                                class="bg-royal-navy text-gold px-10 py-5 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] shadow-xl hover:-translate-y-1 transition-all">
                                Buat Surat Pesanan Formal
                            </a>
                        </div>
                    @else
                        <div class="py-32 text-center">
                            <div class="w-20 h-20 bg-silk rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Tidak ada perencanaan menu untuk tanggal ini</p>
                        </div>
                    @endif

                    <!-- Signatures -->
                    <div class="grid grid-cols-2 gap-12 mt-20">
                        <div>
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Catatan Perencanaan</h4>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed italic">
                                Rekapitulasi ini dihasilkan secara otomatis berdasarkan data porsi dan resep yang ada di sistem Bo To Delpi. Pastikan porsi sudah sesuai dengan jumlah penerima manfaat terbaru.
                            </p>
                        </div>
                        <div class="text-center pt-8">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-20">Penanggung Jawab Gizi</h4>
                            <div class="w-48 h-px bg-gray-200 mx-auto mb-2"></div>
                            <p class="text-xs font-black text-royal-navy uppercase tracking-widest">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest uppercase">SPPG Unit Manager</p>
                        </div>
                    </div>
                </div>

                <!-- Print Action -->
                <div class="p-10 bg-silk border-t border-gray-100 print:hidden flex justify-center gap-4">
                    <button onclick="window.print()" class="bg-royal-navy text-gold px-12 py-5 rounded-2xl text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-royal-navy/90 transition-all flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak Rekap Kebutuhan
                    </button>
                    <a href="{{ route('orders.index') }}" class="px-12 py-5 bg-white border border-gray-200 rounded-2xl text-[11px] font-black text-royal-navy uppercase tracking-[0.3em] hover:bg-gray-50 transition-all">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
