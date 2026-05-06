<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('dishes.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-3xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ $dish->name }}
                </h2>
                <div class="flex items-center mt-1 space-x-2">
                    <span class="px-2 py-0.5 bg-gold/10 text-gold-dark rounded text-[9px] font-black uppercase tracking-widest">Recipe ID: #RCP-{{ str_pad($dish->id, 3, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-gray-300">•</span>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em]">Manajemen Komposisi & Gramasi Hidangan</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            @if(session('success'))
                <div class="p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center text-emerald-600 text-sm font-bold shadow-sm animate-fade-in">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white mr-4 shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Recipe List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                        <div class="p-10">
                            <div class="flex items-center justify-between mb-10">
                                <h3 class="text-[11px] font-black text-royal-navy uppercase tracking-[0.3em] flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Struktur Komposisi
                                </h3>
                                <span class="px-4 py-1.5 bg-silk rounded-full text-[10px] font-black text-royal-navy uppercase tracking-widest border border-gray-50">
                                    {{ $dish->recipes->count() }} Bahan Baku
                                </span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="border-b border-gray-50">
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Material / Bahan</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Gramasi</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Satuan</th>
                                            <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse($dish->recipes as $recipe)
                                            <tr class="hover:bg-silk/30 transition-colors group">
                                                <td class="px-6 py-6 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-10 h-10 rounded-xl bg-royal-navy/5 flex items-center justify-center text-royal-navy/40 mr-4 group-hover:bg-gold/10 group-hover:text-gold transition-colors duration-500">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                        </div>
                                                        <div class="text-sm font-black text-royal-navy">{{ $recipe->material->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-6 whitespace-nowrap">
                                                    <div class="text-sm font-black text-royal-navy tracking-tight">{{ number_format($recipe->quantity, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-6 whitespace-nowrap">
                                                    <span class="px-3 py-1 bg-royal-navy text-gold rounded-lg text-[9px] font-black uppercase tracking-widest shadow-lg shadow-royal-navy/10">{{ $recipe->unit }}</span>
                                                </td>
                                                <td class="px-6 py-6 whitespace-nowrap text-right">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <button type="button" 
                                                            data-id="{{ $recipe->id }}"
                                                            data-name="{{ $recipe->material->name }}"
                                                            data-quantity="{{ $recipe->quantity }}"
                                                            data-unit="{{ $recipe->unit }}"
                                                            data-notes="{{ $recipe->notes }}"
                                                            onclick="openEditModal(this)"
                                                            class="w-10 h-10 rounded-xl flex items-center justify-center text-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                        </button>
                                                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Hapus bahan ini dari resep?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-300 hover:text-red-500 hover:bg-red-50 transition-all duration-300">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-20 text-center">
                                                    <div class="w-16 h-16 bg-silk rounded-full flex items-center justify-center mx-auto mb-4 opacity-50">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                                    </div>
                                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic">Belum ada bahan ditambahkan</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Ingredient Form -->
                <div>
                    <div class="bg-royal-navy rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.1)] p-10 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-20 -mt-20"></div>
                        <div class="relative z-10">
                            <h3 class="text-[11px] font-black text-gold uppercase tracking-[0.3em] mb-8 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                Tambah Komposisi
                            </h3>
                            
                            <form action="{{ route('recipes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-gold/50 uppercase tracking-[0.2em] mb-3 ml-1">Pilih Material / Bahan</label>
                                        <select name="material_id" required class="select2 w-full px-5 py-4 bg-white/5 border-2 border-transparent rounded-[1.5rem] text-sm font-bold text-white focus:bg-white/10 focus:border-gold outline-none transition-all duration-300">
                                            <option value=""></option>
                                            @foreach(\App\Models\Material::all() as $material)
                                                <option value="{{ $material->id }}" class="text-royal-navy">{{ $material->name }} ({{ $material->unit }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black text-gold/50 uppercase tracking-[0.2em] mb-3 ml-1">Gramasi</label>
                                            <input type="number" name="quantity" step="0.01" required class="w-full px-5 py-4 bg-white/5 border-2 border-transparent rounded-[1.5rem] text-sm font-bold text-white focus:bg-white/10 focus:border-gold outline-none transition-all duration-300" placeholder="0.00">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-gold/50 uppercase tracking-[0.2em] mb-3 ml-1">Satuan</label>
                                            <input type="text" name="unit" required class="w-full px-5 py-4 bg-white/5 border-2 border-transparent rounded-[1.5rem] text-sm font-bold text-white focus:bg-white/10 focus:border-gold outline-none transition-all duration-300" placeholder="gr / ml / pcs">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-gold/50 uppercase tracking-[0.2em] mb-3 ml-1">Catatan Khusus</label>
                                        <input type="text" name="notes" class="w-full px-5 py-4 bg-white/5 border-2 border-transparent rounded-[1.5rem] text-sm font-bold text-white focus:bg-white/10 focus:border-gold outline-none transition-all duration-300" placeholder="Opsional...">
                                    </div>

                                    <button type="submit" class="w-full py-5 bg-gold text-royal-navy font-black text-xs uppercase tracking-[0.3em] rounded-[1.5rem] shadow-2xl shadow-gold/10 hover:bg-white hover:-translate-y-1 transition-all duration-500 mt-4">
                                        Tambahkan Bahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>

    {{-- Edit Gramasi Modal --}}
    <div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] shadow-2xl p-10 w-full max-w-md mx-4 animate-fade-in">
            <h3 class="text-[11px] font-black text-royal-navy uppercase tracking-[0.3em] mb-6" id="modal-title">Edit Gramasi Bahan</h3>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-2">Gramasi</label>
                        <input type="number" step="0.0001" name="quantity" id="edit-quantity" required
                            class="w-full px-5 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-2">Satuan</label>
                        <input type="text" name="unit" id="edit-unit" required
                            class="w-full px-5 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all"
                            placeholder="gr / kg / ml">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-2">Catatan</label>
                        <input type="text" name="notes" id="edit-notes"
                            class="w-full px-5 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold outline-none transition-all"
                            placeholder="Opsional">
                    </div>
                </div>
                <div class="flex gap-4 mt-8">
                    <button type="submit" class="flex-1 py-4 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl hover:bg-royal-navy/90 transition-all">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()" class="px-8 py-4 border-2 border-gray-100 rounded-2xl text-gray-400 font-bold text-xs uppercase tracking-widest hover:bg-silk transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const quantity = button.getAttribute('data-quantity');
            const unit = button.getAttribute('data-unit');
            const notes = button.getAttribute('data-notes');

            document.getElementById('modal-title').textContent = 'Edit: ' + name;
            document.getElementById('edit-form').action = '/recipes/' + id;
            document.getElementById('edit-quantity').value = quantity;
            document.getElementById('edit-unit').value = unit;
            document.getElementById('edit-notes').value = notes || '';
            const modal = document.getElementById('edit-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeEditModal() {
            const modal = document.getElementById('edit-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.getElementById('edit-modal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });
    </script>
</x-app-layout>
