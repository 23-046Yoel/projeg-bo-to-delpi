<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-royal-navy italic">
            {{ __('Cek Kebutuhan Bahan') }}
        </h2>
        <p class="text-xs font-bold uppercase tracking-[0.3em] text-gold-dark mt-1">Kalkulator Logistik & Pangan</p>
    </x-slot>

    <div class="space-y-8">
        <!-- Input Card -->
        <div class="bg-white rounded-[2rem] border border-gold/10 shadow-2xl shadow-royal-navy/5 overflow-hidden">
            <div class="bg-royal-navy p-6 flex items-center justify-between">
                <h3 class="text-white font-black italic tracking-tight">Kalkulator Porsi</h3>
                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            
            <form action="{{ route('requirements.calculate') }}" method="POST" class="p-8 grid md:grid-cols-3 gap-8 items-end">
                @csrf
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pilih Menu / Masakan</label>
                    <select name="dish_id" class="w-full bg-silk border border-gold/20 rounded-xl p-4 text-sm outline-none focus:border-gold transition-all appearance-none cursor-pointer">
                        @foreach($dishes as $dish)
                            <option value="{{ $dish->id }}" {{ (isset($selected_dish) && $selected_dish->id == $dish->id) ? 'selected' : '' }}>{{ $dish->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jumlah Porsi (Target)</label>
                    <input type="number" name="portions" value="{{ $portions ?? 100 }}" class="w-full bg-silk border border-gold/20 rounded-xl p-4 text-sm outline-none focus:border-gold transition-all" required>
                </div>
                <button type="submit" class="bg-gold hover:bg-gold-dark text-white font-black text-xs uppercase tracking-[0.2em] py-4 rounded-xl shadow-lg shadow-gold/20 transition-all hover:-translate-y-1 active:scale-95">
                    HITUNG KEBUTUHAN
                </button>
            </form>
        </div>

        @if(isset($requirements))
            <!-- Ayam Special Alert -->
            @if($has_ayam)
                <div class="bg-gradient-to-r from-royal-navy to-slate-800 rounded-[2rem] p-8 border-l-8 border-gold shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-gold/5 rounded-full blur-3xl group-hover:bg-gold/10 transition-all duration-700"></div>
                    <div class="relative z-10 flex items-start gap-6">
                        <div class="w-16 h-16 bg-gold/20 rounded-2xl flex items-center justify-center text-gold shadow-inner">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-gold font-black italic text-xl mb-2 italic">Informasi Khusus: Bahan Ayam Terdeteksi</h4>
                            <p class="text-white/60 text-sm leading-relaxed max-w-2xl">
                                Kebutuhan ayam memerlukan proses pemotongan dan pembersihan yang memakan waktu. 
                                <strong class="text-white">Mohon pastikan pemesanan dilakukan minimal 24 jam sebelum waktu distribusi</strong> 
                                untuk menjamin kualitas kesegaran daging dan ketepatan waktu pengolahan di dapur SPPG.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Results Table -->
            <div class="bg-white rounded-[2rem] border border-gold/5 shadow-xl shadow-royal-navy/5 overflow-hidden">
                <div class="p-8 border-b border-silk-premium flex justify-between items-center">
                    <div>
                        <h4 class="font-black text-royal-navy playfair italic text-lg">{{ $selected_dish->name }}</h4>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Estimasi Bahan untuk {{ number_format($portions) }} Porsi</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-silk-premium flex items-center justify-center text-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-silk-premium">
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Nama Bahan</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Total Kebutuhan</th>
                                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-silk-premium">
                            @foreach($requirements as $req)
                                <tr class="hover:bg-silk transition-colors duration-200">
                                    <td class="px-8 py-6">
                                        <span class="font-black text-royal-navy">{{ $req['material_name'] }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-block px-3 py-1 bg-royal-navy/5 text-royal-navy rounded-lg font-black text-sm">
                                            {{ number_format($req['total_quantity'], 1) }} {{ $req['unit'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        @if($req['is_ayam'])
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gold/10 text-gold-dark rounded-full text-[10px] font-black tracking-widest uppercase">
                                                <span class="w-1.5 h-1.5 bg-gold rounded-full animate-pulse"></span>
                                                Prioritas Tinggi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black tracking-widest uppercase">
                                                Standar
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-silk-premium text-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Data dihitung berdasarkan standar resep MBG Foundation Hub &copy; 2026</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
