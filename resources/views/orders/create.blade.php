<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('orders.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Buat Surat Pesanan (PO)') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Pemesanan Bahan Baku ke Supplier</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 p-12">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <div class="space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Supplier</label>
                                <select name="supplier_id" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tanggal Pesanan</label>
                                <input type="date" name="order_date" required value="{{ date('Y-m-d') }}"
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                            </div>
                        </div>

                        <div class="border-t border-gray-50 pt-10">
                            <div class="bg-silk rounded-[2rem] p-6 mb-10 border-2 border-dashed border-gray-200">
                                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                    <div>
                                        <h4 class="text-xs font-black text-royal-navy uppercase tracking-widest">Tarik Otomatis dari Menu</h4>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase mt-1">Sistem akan menghitung kebutuhan bahan berdasarkan rencana menu</p>
                                    </div>
                                    <div class="flex flex-col md:flex-row items-center gap-4">
                                        <div class="flex flex-col">
                                            <label class="text-[9px] font-black text-royal-navy/50 uppercase mb-1 ml-1">Mulai</label>
                                            <input type="date" id="start-date" value="{{ date('Y-m-d') }}" 
                                                class="px-4 py-3 bg-white border-2 border-transparent rounded-xl text-xs font-black text-royal-navy focus:border-gold outline-none shadow-sm">
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-[9px] font-black text-royal-navy/50 uppercase mb-1 ml-1">Sampai</label>
                                            <input type="date" id="end-date" value="{{ date('Y-m-d') }}" 
                                                class="px-4 py-3 bg-white border-2 border-transparent rounded-xl text-xs font-black text-royal-navy focus:border-gold outline-none shadow-sm">
                                        </div>
                                        <button type="button" onclick="fetchRequirements()" id="fetch-btn"
                                            class="mt-4 md:mt-0 px-8 py-3 bg-royal-navy text-gold rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy/90 transition-all shadow-lg flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            Ambil Data Bahan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-[10px] font-black text-royal-navy uppercase tracking-[0.2em]">Daftar Item Pesanan (Hasil Agregasi)</h3>
                                <button type="button" onclick="addItem()" class="px-5 py-2.5 bg-silk text-royal-navy border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 transition-all flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Item Manual
                                </button>
                            </div>

                            <div id="items-container" class="space-y-4">
                                @forelse($prepopulatedItems as $idx => $item)
                                    <div class="item-row grid grid-cols-12 gap-4 items-center animate-fadeIn bg-white p-2 rounded-2xl hover:shadow-md transition-all border border-transparent hover:border-gold/20">
                                        <div class="col-span-4">
                                            <select name="items[{{ $idx }}][material_id]" required onchange="updatePrice(this)" class="w-full px-6 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none">
                                                @foreach($materials as $material)
                                                    <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}" {{ $item['material_id'] == $material->id ? 'selected' : '' }}>
                                                        {{ $material->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-2">
                                            <input type="number" step="0.0001" name="items[{{ $idx }}][quantity]" value="{{ $item['quantity'] }}" required class="w-full px-4 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Qty">
                                        </div>
                                        <div class="col-span-2">
                                            <input type="text" name="items[{{ $idx }}][unit]" value="{{ $item['unit'] }}" required class="unit-input w-full px-4 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Unit">
                                        </div>
                                        <div class="col-span-3">
                                            <input type="number" name="items[{{ $idx }}][price]" value="{{ $item['price'] }}" required class="price-input w-full px-4 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Price">
                                        </div>
                                        <div class="col-span-1 text-right">
                                            <button type="button" onclick="removeRow(this)" class="p-2 text-red-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="item-row grid grid-cols-12 gap-4 items-center bg-white p-2 rounded-2xl border border-gray-100">
                                        <div class="col-span-4">
                                            <select name="items[0][material_id]" required onchange="updatePrice(this)" class="w-full px-6 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none">
                                                <option value="">Pilih Bahan...</option>
                                                @foreach($materials as $material)
                                                    <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-2">
                                            <input type="number" step="0.0001" name="items[0][quantity]" required class="w-full px-4 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Qty">
                                        </div>
                                        <div class="col-span-2">
                                            <input type="text" name="items[0][unit]" required class="unit-input w-full px-4 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Unit">
                                        </div>
                                        <div class="col-span-3">
                                            <input type="number" name="items[0][price]" required class="price-input w-full px-4 py-4 bg-silk/50 border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Price">
                                        </div>
                                        <div class="col-span-1 text-right">
                                            <button type="button" onclick="removeRow(this)" class="p-2 text-red-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="pt-8 border-t border-gray-50 flex space-x-4">
                            <button type="submit" class="flex-1 py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                Simpan & Generate PO
                            </button>
                             <a href="{{ route('orders.index') }}" class="px-12 py-5 border-2 border-gray-100 rounded-2xl text-gray-400 font-bold uppercase tracking-[0.2em] text-[10px] hover:bg-silk transition-all flex items-center">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let rowCount = {{ count($prepopulatedItems) ?: 1 }};
        const materials = @json($materials);

        async function fetchRequirements() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const btn = document.getElementById('fetch-btn');
            
            if (!startDate || !endDate) {
                alert('Pilih rentang tanggal terlebih dahulu');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menarik Bahan...';

            try {
                const response = await fetch(`{{ route('orders.calculate') }}?start_date=${startDate}&end_date=${endDate}`);
                const data = await response.json();

                if (data.length === 0) {
                    alert('Tidak ada rencana menu untuk rentang tanggal ini.');
                } else {
                    if (confirm(`Ditemukan ${data.length} jenis bahan baku dari seluruh menu dalam rentang tanggal tersebut. Apakah Anda ingin memasukkannya ke daftar? (Item yang ada sekarang akan dikosongkan)`)) {
                        document.getElementById('items-container').innerHTML = '';
                        rowCount = 0;
                        data.forEach(item => {
                            addCalculatedItem(item);
                        });
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal mengambil data kebutuhan bahan.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Ambil Data Bahan';
            }
        }

        function addCalculatedItem(item) {
            const container = document.getElementById('items-container');
            const row = document.createElement('div');
            row.className = 'item-row grid grid-cols-12 gap-4 items-center animate-fadeIn mt-4';
            
            let options = '<option value="">Pilih Bahan...</option>';
            materials.forEach(m => {
                options += `<option value="${m.id}" data-price="${m.price}" data-unit="${m.unit}" ${m.id == item.material_id ? 'selected' : ''}>${m.name}</option>`;
            });

            row.innerHTML = `
                <div class="col-span-4">
                    <select name="items[${rowCount}][material_id]" required onchange="updatePrice(this)" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none">
                        ${options}
                    </select>
                </div>
                <div class="col-span-2">
                    <input type="number" step="0.0001" name="items[${rowCount}][quantity]" value="${item.quantity}" required class="w-full px-4 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Qty">
                </div>
                <div class="col-span-2">
                    <input type="text" name="items[${rowCount}][unit]" value="${item.unit}" required class="unit-input w-full px-4 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Unit">
                </div>
                <div class="col-span-3">
                    <input type="number" name="items[${rowCount}][price]" value="${item.price}" required class="price-input w-full px-4 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Price">
                </div>
                <div class="col-span-1 text-right">
                    <button type="button" onclick="removeRow(this)" class="text-red-300 hover:text-red-500 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            container.appendChild(row);
            rowCount++;
        }

        function updatePrice(select) {
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const unit = selectedOption.getAttribute('data-unit');
            const row = select.closest('.item-row');
            
            const priceInput = row.querySelector('.price-input');
            const unitInput = row.querySelector('.unit-input');
            
            if (priceInput) priceInput.value = price || 0;
            if (unitInput) unitInput.value = unit || '';
        }

        function addItem() {
            const container = document.getElementById('items-container');
            const row = document.createElement('div');
            row.className = 'item-row grid grid-cols-12 gap-4 items-center animate-fadeIn mt-4';
            
            let options = '<option value="">Pilih Bahan...</option>';
            materials.forEach(m => {
                options += `<option value="${m.id}" data-price="${m.price}" data-unit="${m.unit}">${m.name}</option>`;
            });

            row.innerHTML = `
                <div class="col-span-4">
                    <select name="items[${rowCount}][material_id]" required onchange="updatePrice(this)" class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none">
                        ${options}
                    </select>
                </div>
                <div class="col-span-2">
                    <input type="number" step="0.0001" name="items[${rowCount}][quantity]" required class="w-full px-4 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Qty">
                </div>
                <div class="col-span-2">
                    <input type="text" name="items[${rowCount}][unit]" required class="unit-input w-full px-4 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Unit">
                </div>
                <div class="col-span-3">
                    <input type="number" name="items[${rowCount}][price]" required class="price-input w-full px-4 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Price">
                </div>
                <div class="col-span-1 text-right">
                    <button type="button" onclick="removeRow(this)" class="text-red-300 hover:text-red-500 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            container.appendChild(row);
            rowCount++;
        }

        function removeRow(btn) {
            btn.closest('.item-row').remove();
        }
    </script>
</x-app-layout>
