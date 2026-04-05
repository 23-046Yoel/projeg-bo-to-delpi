<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('distributions.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-royal-navy hover:bg-royal-navy hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Susun Rute Distribusi') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Pilih Driver dan Tentukan Sekolah Tujuan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">                                                                                                                                                                                                                                                   
            <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                <div class="p-12">
                    <form action="{{ route('distributions.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="date" class="block text-[10px] font-black text-royal-navy uppercase  tracking-[0.2em] mb-3">Tanggal Distribusi</label>
                                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                                        class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                    @error('date') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-3">
                                        <label for="driver_id" class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em]">Pilih Driver</label>
                                        <a href="{{ route('users.create') }}" class="text-[9px] font-black text-gold-dark hover:text-gold uppercase tracking-wider flex items-center transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                            Tambah Driver Baru
                                        </a>
                                    </div>
                                    <select id="driver_id" name="driver_id" required class="w-full px-6 py-4 bg-silk border-2 border-transparent rounded-2xl text-sm font-bold text-royal-navy focus:bg-white focus:border-gold transition-all outline-none">
                                        <option value="">-- Pilih Driver --</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('driver_id') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] mb-3">Tujuan Pengiriman (Sekolah / Kelompok)</label>
                                <div class="space-y-3 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($groups as $group)
                                        <div class="flex items-center space-x-3 p-4 bg-silk rounded-2xl group border border-transparent hover:border-gold/20 transition-all">
                                            <label class="flex items-center cursor-pointer flex-1">
                                                <input type="checkbox" name="group_ids[]" value="{{ $group->id }}" class="w-5 h-5 rounded-lg border-2 border-gold text-royal-navy focus:ring-gold">
                                                <div class="ml-4">
                                                    <span class="block text-sm font-bold text-royal-navy group-hover:text-gold-dark transition-colors">{{ $group->name }}</span>
                                                    <span class="text-[10px] font-bold text-slate-400 group-hover:text-slate-500 uppercase tracking-widest">{{ $group->location ?? 'No Address' }} - {{ $group->total_beneficiaries }} Penerima</span>
                                                </div>
                                            </label>
                                            <div class="w-32">
                                                <input type="number" name="quantities[{{ $group->id }}]" value="{{ $group->total_beneficiaries }}" min="1"
                                                    placeholder="Qty Porsi"
                                                    class="w-full px-4 py-2 bg-white border border-gold/20 rounded-xl text-xs font-black text-royal-navy focus:border-gold outline-none">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('group_ids') <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full py-5 bg-royal-navy text-gold font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:bg-royal-navy/90 hover:-translate-y-1 transition-all duration-300">
                                    Simpan & Tugaskan Driver
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
