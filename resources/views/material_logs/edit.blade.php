<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Edit Transaction') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Perbarui Data Arus Bahan SPPG</p>
            </div>
            <div class="flex items-center space-x-2 text-[10px] font-bold text-gray-300 tracking-widest uppercase">
                <span>Inventory</span>
                <span class="text-gold">/</span>
                <span class="text-royal-navy">Edit Log</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-[0_40px_80px_rgba(15,23,42,0.05)] border border-gray-100 overflow-hidden relative">
                <!-- Accent Shapes -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gold/5 -mr-32 -mt-32 rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-royal-navy/5 -ml-16 -mb-16 rounded-full"></div>

                <div class="p-12 relative">
                    <div class="mb-10 text-center">
                        <div class="w-16 h-16 bg-gold rounded-2xl flex items-center justify-center text-royal-navy mx-auto mb-6 shadow-xl shadow-gold/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-royal-navy font-playfair tracking-tight mb-2">Edit Log Bahan</h3>
                        <p class="text-sm text-gray-400 font-medium">Ubah data log yang sudah terdaftar.</p>
                    </div>

                    <form action="{{ route('material_logs.update', $materialLog) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Material Input -->
                            <div class="group">
                                <x-input-label for="material_name" :value="__('Nama Bahan Baku')" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-gray-300 group-focus-within:text-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <x-text-input id="material_name" name="material_name" list="material-list" class="pl-14 w-full" :value="old('material_name', $materialLog->material->name)" required placeholder="Ketik nama bahan..." />
                                </div>
                                <datalist id="material-list">
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->name }}">
                                    @endforeach
                                </datalist>
                                <x-input-error :messages="$errors->get('material_name')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Type -->
                                <div class="group">
                                    <x-input-label for="type" :value="__('Status Arus')" />
                                    <div class="relative">
                                        <select id="type" name="type" class="bg-silk border-transparent focus:border-gold focus:ring-4 focus:ring-gold/10 rounded-2xl py-4 px-6 w-full text-royal-navy font-bold appearance-none transition-all">
                                            <option value="in" {{ old('type', $materialLog->type) == 'in' ? 'selected' : '' }}>🟢 Bahan Masuk (Masuk)</option>
                                            <option value="out" {{ old('type', $materialLog->type) == 'out' ? 'selected' : '' }}>🔴 Bahan Keluar (Pakai)</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                <!-- Quantity -->
                                <div class="group">
                                    <x-input-label for="quantity" :value="__('Jumlah / Kuantitas')" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-gray-300 group-focus-within:text-gold transition-colors font-black text-xs">UNIT</div>
                                        <x-text-input id="quantity" class="pl-16 w-full" type="number" step="0.01" name="quantity" :value="old('quantity', $materialLog->quantity)" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="group">
                                <x-input-label for="date" :value="__('Tanggal Laporan')" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-gray-300 group-focus-within:text-gold transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <x-text-input id="date" class="pl-14 w-full" type="date" name="date" :value="old('date', \Carbon\Carbon::parse($materialLog->date)->format('Y-m-d'))" required />
                                </div>
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('material_logs.index') }}" class="text-[10px] font-black text-gray-300 uppercase tracking-widest hover:text-royal-navy transition-colors">Batal</a>
                            <x-primary-button class="!px-12">
                                {{ __('Update Log') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
