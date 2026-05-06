<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Isi LPJ Harian') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Laporan Pertanggungjawaban Harian SPPG</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('production.daily-lpj.index') }}" class="px-5 py-2 bg-silk text-royal-navy border border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 transition-all">
                    Batal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-silk/50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('production.daily-lpj.store') }}" method="POST" id="lpjForm">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $data['menu_id'] }}">
                <input type="hidden" name="sppg_id" value="{{ $data['sppg_id'] }}">
                <input type="hidden" name="date" value="{{ $data['date'] }}">

                <!-- IDENTITAS & RINGKASAN -->
                <div class="premium-card p-8 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                <span class="w-2 h-2 bg-gold rounded-full"></span>
                                IDENTITAS SPPG
                            </h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 items-center">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Nama SPPG</span>
                                    <span class="col-span-2 text-xs font-black text-royal-navy">: {{ $data['sppg_name'] }}</span>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Tanggal</span>
                                    <span class="col-span-2 text-xs font-black text-royal-navy">: {{ \Carbon\Carbon::parse($data['date'])->translatedFormat('d F Y') }}</span>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Menu Utama</span>
                                    <span class="col-span-2 text-xs font-black text-royal-navy uppercase">: {{ $menu?->karbo ?? '(Isi Manual)' }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                <span class="w-2 h-2 bg-gold rounded-full"></span>
                                RINGKASAN KEGIATAN
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Total Produksi</label>
                                    <input type="number" step="0.01" name="total_production" value="{{ $data['total_production'] }}" class="w-32 px-3 py-1 bg-silk/50 border-b border-gray-200 text-xs font-black text-right focus:border-gold outline-none">
                                </div>
                                <div class="flex items-center justify-between">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Total Distribusi</label>
                                    <input type="number" step="0.01" name="total_distribution" value="{{ $data['total_distribution'] }}" class="w-32 px-3 py-1 bg-silk/50 border-b border-gray-200 text-xs font-black text-right focus:border-gold outline-none">
                                </div>
                                <div class="flex items-center justify-between">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Sisa Makanan</label>
                                    <input type="number" step="0.01" name="leftover_food" value="{{ $data['leftover_food'] }}" class="w-32 px-3 py-1 bg-silk/50 border-b border-gray-200 text-xs font-black text-right focus:border-gold outline-none">
                                </div>
                                <div class="flex items-center justify-between">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Food Waste</label>
                                    <input type="number" step="0.01" name="food_waste" value="{{ $data['food_waste'] }}" class="w-32 px-3 py-1 bg-silk/50 border-b border-gray-200 text-xs font-black text-right focus:border-gold outline-none">
                                </div>
                                <div class="flex items-center justify-between">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase">Total Pengeluaran</label>
                                    <input type="number" step="0.01" name="total_expenditure" value="{{ $data['total_expenditure'] }}" class="w-32 px-3 py-1 bg-silk/50 border-b border-gray-200 text-xs font-black text-right focus:border-gold outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GIZI & PENERIMAAN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Menu & Gizi (Pre-filled from Menu) -->
                    <div class="premium-card p-8">
                        <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6">MENU & KECUKUPAN GIZI</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Karbohidrat</span>
                                <span class="text-[10px] font-black text-royal-navy uppercase">{{ $menu?->karbo ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Protein Hewani</span>
                                <span class="text-[10px] font-black text-royal-navy uppercase">{{ $menu?->protein_hewani ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Protein Nabati</span>
                                <span class="text-[10px] font-black text-royal-navy uppercase">{{ $menu?->protein_nabati ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Sayur</span>
                                <span class="text-[10px] font-black text-royal-navy uppercase">{{ $menu?->sayur ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Buah</span>
                                <span class="text-[10px] font-black text-royal-navy uppercase">{{ $menu?->buah ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-[10px] font-bold text-gold-dark uppercase">Total Energi / Protein</span>
                                <span class="text-[10px] font-black text-gold-dark">{{ $menu?->energy ?? 0 }} kkal / {{ $menu?->protein ?? 0 }} g</span>
                            </div>
                        </div>
                    </div>

                    <!-- Penerimaan Bahan Baku -->
                    <div class="premium-card p-8">
                        <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6 flex justify-between items-center">
                            PENERIMAAN BAHAN BAKU
                            <button type="button" onclick="addRow('receiptsTable')" class="text-gold hover:text-gold-dark transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-[10px]" id="receiptsTable">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="py-2 text-left text-gray-400 uppercase">Bahan</th>
                                        <th class="py-2 text-right text-gray-400 uppercase">Qty</th>
                                        <th class="py-2 text-center text-gray-400 uppercase">Ket</th>
                                        <th class="py-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['material_receipts'] as $index => $item)
                                        <tr class="border-b border-gray-50">
                                            <td class="py-2"><input type="text" name="material_receipts[{{ $index }}][name]" value="{{ $item['name'] }}" class="w-full bg-transparent border-none p-0 font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="number" step="0.01" name="material_receipts[{{ $index }}][qty]" value="{{ $item['qty'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="text" name="material_receipts[{{ $index }}][conclusion]" value="{{ $item['conclusion'] }}" class="w-full bg-transparent border-none p-0 text-center font-bold focus:ring-0"></td>
                                            <td class="py-2 text-right"><button type="button" onclick="removeRow(this)" class="text-red-300 hover:text-red-500">×</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- HACCP PRODUKSI -->
                <div class="premium-card p-8 mb-8">
                    <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6">HACCP PRODUKSI</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-[10px] font-black text-gold-dark uppercase tracking-widest mb-4">1. Persiapan</h4>
                            <table class="w-full text-[10px]" id="prepTable">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="py-2 text-left text-gray-400 uppercase">Item</th>
                                        <th class="py-2 text-right text-gray-400 uppercase">Terima</th>
                                        <th class="py-2 text-right text-gray-400 uppercase">Hasil</th>
                                        <th class="py-2 text-center text-gray-400 uppercase">Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['haccp_preparation'] as $index => $item)
                                        <tr class="border-b border-gray-50">
                                            <td class="py-2"><input type="text" name="haccp_preparation[{{ $index }}][material]" value="{{ $item['material'] }}" class="w-full bg-transparent border-none p-0 font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="number" step="0.01" name="haccp_preparation[{{ $index }}][qty_received]" value="{{ $item['qty_received'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="number" step="0.01" name="haccp_preparation[{{ $index }}][qty_result]" value="{{ $item['qty_result'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="text" name="haccp_preparation[{{ $index }}][start_time]" value="{{ $item['start_time'] }}" class="w-full bg-transparent border-none p-0 text-center font-bold focus:ring-0"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black text-gold-dark uppercase tracking-widest mb-4">2. Pengolahan</h4>
                            <table class="w-full text-[10px]" id="procTable">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="py-2 text-left text-gray-400 uppercase">Masakan</th>
                                        <th class="py-2 text-right text-gray-400 uppercase">Terima</th>
                                        <th class="py-2 text-right text-gray-400 uppercase">Hasil</th>
                                        <th class="py-2 text-center text-gray-400 uppercase">Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['haccp_processing'] as $index => $item)
                                        <tr class="border-b border-gray-50">
                                            <td class="py-2"><input type="text" name="haccp_processing[{{ $index }}][dish]" value="{{ $item['dish'] }}" class="w-full bg-transparent border-none p-0 font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="number" step="0.01" name="haccp_processing[{{ $index }}][qty_received]" value="{{ $item['qty_received'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="number" step="0.01" name="haccp_processing[{{ $index }}][qty_result]" value="{{ $item['qty_result'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold focus:ring-0"></td>
                                            <td class="py-2"><input type="text" name="haccp_processing[{{ $index }}][start_time]" value="{{ $item['start_time'] }}" class="w-full bg-transparent border-none p-0 text-center font-bold focus:ring-0"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- DISTRIBUSI -->
                <div class="premium-card p-8 mb-8">
                    <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6">DISTRIBUSI</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-[10px]" id="distTable">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="py-2 text-left text-gray-400 uppercase">Penerima Manfaat</th>
                                    <th class="py-2 text-right text-gray-400 uppercase">Qty</th>
                                    <th class="py-2 text-center text-gray-400 uppercase">Tiba</th>
                                    <th class="py-2 text-center text-gray-400 uppercase">Org-leptik</th>
                                    <th class="py-2 text-center text-gray-400 uppercase">BAST</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['distribution_data'] as $index => $item)
                                    <tr class="border-b border-gray-50">
                                        <td class="py-2"><input type="text" name="distribution_data[{{ $index }}][beneficiary]" value="{{ $item['beneficiary'] }}" class="w-full bg-transparent border-none p-0 font-bold focus:ring-0"></td>
                                        <td class="py-2"><input type="number" step="0.01" name="distribution_data[{{ $index }}][qty]" value="{{ $item['qty'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold focus:ring-0"></td>
                                        <td class="py-2"><input type="text" name="distribution_data[{{ $index }}][arrival_time]" value="{{ $item['arrival_time'] }}" class="w-full bg-transparent border-none p-0 text-center font-bold focus:ring-0"></td>
                                        <td class="py-2"><input type="text" name="distribution_data[{{ $index }}][organoleptic]" value="{{ $item['organoleptic'] }}" class="w-full bg-transparent border-none p-0 text-center font-bold focus:ring-0"></td>
                                        <td class="py-2"><input type="text" name="distribution_data[{{ $index }}][bast]" value="{{ $item['bast'] }}" class="w-full bg-transparent border-none p-0 text-center font-bold focus:ring-0"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KEUANGAN HARIAN -->
                <div class="premium-card p-8 mb-8">
                    <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6">KEUANGAN HARIAN</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-[10px]">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="py-2 text-left text-gray-400 uppercase">Informasi Keuangan</th>
                                    <th class="py-2 text-right text-gray-400 uppercase">Virtual</th>
                                    <th class="py-2 text-right text-gray-400 uppercase">Kas Kecil</th>
                                </tr>
                            </thead>
                            <tbody class="space-y-1">
                                <tr class="border-b border-gray-50">
                                    <td class="py-2 text-gray-600 font-bold">Saldo Awal</td>
                                    <td><input type="number" step="0.01" name="initial_balance_virtual" value="{{ $data['initial_balance_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-black text-royal-navy focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="initial_balance_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-black text-royal-navy focus:ring-0"></td>
                                </tr>
                                <tr class="border-b border-gray-50">
                                    <td class="py-2 text-gray-600 font-bold">Pengeluaran Bahan Baku</td>
                                    <td><input type="number" step="0.01" name="expenditure_materials_virtual" value="{{ $data['expenditure_materials_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-black text-royal-navy focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="expenditure_materials_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-black text-royal-navy focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-400 font-bold uppercase text-[8px] pl-4">1. Gaji Relawan</td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_salary_virtual" value="{{ $data['expenditure_ops_salary_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_salary_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-400 font-bold uppercase text-[8px] pl-4">2. Gas</td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_gas_virtual" value="{{ $data['expenditure_ops_gas_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_gas_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-gray-400 font-bold uppercase text-[8px] pl-4">3. Listrik</td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_electricity_virtual" value="{{ $data['expenditure_ops_electricity_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_electricity_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                </tr>
                                <tr class="border-b border-gray-50">
                                    <td class="py-2 text-gray-400 font-bold uppercase text-[8px] pl-4">4. Administrasi</td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_admin_virtual" value="{{ $data['expenditure_ops_admin_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="expenditure_ops_admin_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-bold text-gray-500 focus:ring-0"></td>
                                </tr>
                                <tr class="border-b border-gray-50">
                                    <td class="py-2 text-gray-600 font-bold">Pengeluaran Insentif</td>
                                    <td><input type="number" step="0.01" name="expenditure_incentive_virtual" value="{{ $data['expenditure_incentive_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-black text-royal-navy focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="expenditure_incentive_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-black text-royal-navy focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-royal-navy font-black uppercase text-[11px]">Saldo Akhir</td>
                                    <td><input type="number" step="0.01" name="final_balance_virtual" value="{{ $data['final_balance_virtual'] }}" class="w-full bg-transparent border-none p-0 text-right font-black text-gold-dark text-sm focus:ring-0"></td>
                                    <td><input type="number" step="0.01" name="final_balance_cash" value="0" class="w-full bg-transparent border-none p-0 text-right font-black text-gold-dark text-sm focus:ring-0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KESIMPULAN & TTD -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="premium-card p-8">
                        <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6">KESIMPULAN HARIAN</h3>
                        <textarea name="conclusion" rows="4" class="w-full bg-silk/30 border-2 border-transparent rounded-xl text-xs font-bold p-4 focus:border-gold outline-none transition-all">{{ $data['conclusion'] }}</textarea>
                    </div>
                    <div class="premium-card p-8">
                        <h3 class="text-xs font-black text-royal-navy uppercase tracking-[0.2em] mb-6">PENGESAHAN</h3>
                        <div class="space-y-3">
                            @foreach($data['signatures'] as $role => $name)
                                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase">{{ str_replace('_', ' ', $role) }}</span>
                                    <input type="text" name="signatures[{{ $role }}]" value="{{ $name }}" class="bg-transparent border-none p-0 text-[10px] font-black text-royal-navy text-right focus:ring-0">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mb-12">
                    <button type="submit" class="px-12 py-4 bg-royal-navy text-white text-xs font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-royal-navy/90 transition-all shadow-2xl shadow-royal-navy/20">
                        Simpan Laporan LPJ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addRow(tableId) {
            const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
            const rowCount = table.rows.length;
            const row = table.insertRow(rowCount);
            row.className = "border-b border-gray-50";
            
            if(tableId === 'receiptsTable') {
                row.innerHTML = `
                    <td class="py-2"><input type="text" name="material_receipts[${rowCount}][name]" class="w-full bg-transparent border-none p-0 font-bold focus:ring-0"></td>
                    <td class="py-2"><input type="number" step="0.01" name="material_receipts[${rowCount}][qty]" class="w-full bg-transparent border-none p-0 text-right font-bold focus:ring-0"></td>
                    <td class="py-2"><input type="text" name="material_receipts[${rowCount}][conclusion]" value="Diterima" class="w-full bg-transparent border-none p-0 text-center font-bold focus:ring-0"></td>
                    <td class="py-2 text-right"><button type="button" onclick="removeRow(this)" class="text-red-300 hover:text-red-500">×</button></td>
                `;
            }
        }

        function removeRow(btn) {
            const row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
</x-app-layout>
