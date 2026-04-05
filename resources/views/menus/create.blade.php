<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('menus.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Plan Daily Menu') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Tukan Menu & Estimasi Porsi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 p-12">
                <form action="{{ route('menus.store') }}" method="POST" id="menuForm">
                    @csrf
                    <div class="space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Menu Date</label>
                                <input type="date" name="date" required value="{{ old('date', date('Y-m-d')) }}"
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Notes (Optional)</label>
                                <input type="text" name="content" value="{{ old('content') }}"
                                    class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none"
                                    placeholder="Contoh: Menu Makan Siang">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-[10px] font-black text-royal-navy uppercase tracking-[0.2em]">Select Dishes & Portions</h3>
                                <button type="button" onclick="addDishRow()" class="px-4 py-2 bg-royal-navy text-gold rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-royal-navy/90 transition-all">
                                    + Add Item
                                </button>
                            </div>

                            <div id="dishContainer" class="space-y-6 sm:space-y-4">
                                <!-- Dish rows will be added here -->
                                <div class="dish-row grid grid-cols-12 gap-3 sm:gap-4 items-center animate-fadeIn bg-silk sm:bg-transparent p-4 sm:p-0 rounded-2xl sm:rounded-none border sm:border-0 border-gray-100/50">
                                    <div class="col-span-12 sm:col-span-7">
                                        <label class="block sm:hidden text-[9px] font-black text-royal-navy uppercase tracking-widest mb-2">Select Dish</label>
                                        <select name="dishes[0][id]" required class="w-full px-5 sm:px-6 py-3 sm:py-4 bg-white sm:bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none">
                                            <option value="">Pilih Hidangan</option>
                                            @foreach($dishes as $dish)
                                                <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-8 sm:col-span-3">
                                        <label class="block sm:hidden text-[9px] font-black text-royal-navy uppercase tracking-widest mb-2">Portions</label>
                                        <input type="number" name="dishes[0][portions]" required min="1" class="w-full px-5 sm:px-6 py-3 sm:py-4 bg-white sm:bg-silk border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Qty">
                                    </div>
                                    <div class="col-span-4 sm:col-span-2 text-right pt-6 sm:pt-0">
                                        <button type="button" onclick="removeRow(this)" class="p-3 sm:p-4 text-red-300 hover:text-red-500 transition-colors bg-white sm:bg-transparent rounded-xl">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50">
                            <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                Save Plan & Auto-Calculate Materials
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let rowIdx = 1;
        const dishes = @json($dishes);

        function addDishRow() {
            const container = document.getElementById('dishContainer');
            const row = document.createElement('div');
            row.className = 'dish-row grid grid-cols-12 gap-3 sm:gap-4 items-center animate-fadeIn bg-silk sm:bg-transparent p-4 sm:p-0 rounded-2xl sm:rounded-none border sm:border-0 border-gray-100/50';
            
            let options = '<option value="">Pilih Hidangan</option>';
            dishes.forEach(d => {
                options += `<option value="${d.id}">${d.name}</option>`;
            });

            row.innerHTML = `
                <div class="col-span-12 sm:col-span-7">
                    <label class="block sm:hidden text-[9px] font-black text-royal-navy uppercase tracking-widest mb-2">Select Dish</label>
                    <select name="dishes[${rowIdx}][id]" required class="w-full px-5 sm:px-6 py-3 sm:py-4 bg-white sm:bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none">
                        ${options}
                    </select>
                </div>
                <div class="col-span-8 sm:col-span-3">
                    <label class="block sm:hidden text-[9px] font-black text-royal-navy uppercase tracking-widest mb-2">Portions</label>
                    <input type="number" name="dishes[${rowIdx}][portions]" required min="1" class="w-full px-5 sm:px-6 py-3 sm:py-4 bg-white sm:bg-silk border-2 border-transparent rounded-2xl text-sm font-black text-royal-navy focus:bg-white focus:border-gold outline-none" placeholder="Qty">
                </div>
                <div class="col-span-4 sm:col-span-2 text-right pt-6 sm:pt-0">
                    <button type="button" onclick="removeRow(this)" class="p-3 sm:p-4 text-red-300 hover:text-red-500 transition-colors bg-white sm:bg-transparent rounded-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            container.appendChild(row);
            rowIdx++;
        }

        function removeRow(btn) {
            btn.closest('.dish-row').remove();
        }
    </script>
</x-app-layout>
