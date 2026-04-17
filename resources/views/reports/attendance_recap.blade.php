<x-app-layout>
    <div class="py-12 bg-silk min-h-screen">
        <div class="max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/50 p-8 relative overflow-hidden">
                <!-- Background Accents -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-gold-light/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-gold-dark/5 rounded-full blur-3xl"></div>

                <div class="relative">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
                        <div>
                            <span class="inline-block px-4 py-1.5 rounded-full bg-gold-light/10 text-gold-dark text-[10px] font-black uppercase tracking-[0.2em] mb-4">Attendance Recap</span>
                            <h2 class="text-4xl font-serif text-slate-800 tracking-tight">Rekap Kehadiran Relawan</h2>
                            <p class="text-slate-500 text-sm mt-2 font-medium italic underline underline-offset-4 decoration-gold-light/30 transition-all hover:decoration-gold-light cursor-default">Periode: {{ $data['month_name'] }}</p>
                        </div>

                        <!-- Month Selector Form -->
                        <form action="{{ route('reports.attendance-recap') }}" method="GET" class="flex items-center gap-3">
                            <div class="group">
                                <select name="month" class="bg-white border-2 border-slate-100 rounded-2xl px-6 py-3 text-sm font-bold text-slate-700 outline-none focus:border-gold-light transition-all appearance-none cursor-pointer">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $data['month'] == $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create(2026, $m, 1)->translatedFormat('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group">
                                <select name="year" class="bg-white border-2 border-slate-100 rounded-2xl px-6 py-3 text-sm font-bold text-slate-700 outline-none focus:border-gold-light transition-all appearance-none cursor-pointer">
                                    @foreach(range(now()->year - 2, now()->year + 2) as $y)
                                        <option value="{{ $y }}" {{ $data['year'] == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="p-3 bg-slate-900 text-gold-light rounded-2xl hover:bg-gold-dark hover:text-white transition-all shadow-lg hover:shadow-gold/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Attendance Table Grid -->
                    <div class="overflow-x-auto rounded-[2rem] border border-slate-100 shadow-sm bg-white/50 backdrop-blur-sm">
                        <table class="w-full text-left border-collapse min-w-[1200px]">
                            <thead>
                                <tr class="bg-slate-900">
                                    <th class="sticky left-0 z-20 bg-slate-900 px-6 py-5 text-[10px] font-black text-gold-light uppercase tracking-widest border-r border-slate-800 w-[50px] text-center">No</th>
                                    <th class="sticky left-[50px] z-20 bg-slate-900 px-6 py-5 text-[10px] font-black text-gold-light uppercase tracking-widest border-r border-slate-800 min-w-[200px]">Nama Relawan</th>
                                    <th class="px-6 py-5 text-[10px] font-black text-white/40 uppercase tracking-widest border-r border-slate-800 text-center">Telepon</th>
                                    @for($i = 1; $i <= $data['daysInMonth']; $i++)
                                        <th class="px-2 py-5 text-[10px] font-black text-gold-light/50 uppercase tracking-tighter border-r border-slate-800 text-center min-w-[35px] {{ \Carbon\Carbon::create($data['year'], $data['month'], $i)->isWeekend() ? 'bg-red-900/10' : '' }}">
                                            {{ $i }}
                                        </th>
                                    @endfor
                                    <th class="px-6 py-5 text-[10px] font-black text-gold-premium uppercase tracking-widest text-center bg-gold-premium/10">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($data['volunteers'] as $index => $volunteer)
                                    <tr class="hover:bg-gold-light/5 transition-colors group">
                                        <td class="sticky left-0 z-10 bg-white group-hover:bg-gold-light/5 px-6 py-4 text-xs font-bold text-slate-400 border-r border-slate-100 text-center">{{ $index + 1 }}</td>
                                        <td class="sticky left-[50px] z-10 bg-white group-hover:bg-gold-light/5 px-6 py-4 border-r border-slate-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 uppercase tracking-tighter overflow-hidden border border-white shadow-sm">
                                                    {{ substr($volunteer->name, 0, 2) }}
                                                </div>
                                                <div class="text-[13px] font-black text-slate-700 tracking-tight uppercase">{{ $volunteer->name }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-[11px] font-bold text-slate-400 text-center border-r border-slate-100">{{ $volunteer->phone ?? '-' }}</td>
                                        
                                        @php $totalHadir = 0; @endphp
                                        @for($i = 1; $i <= $data['daysInMonth']; $i++)
                                            @php 
                                                $isPresent = isset($data['attendances'][$volunteer->id][$i]);
                                                if($isPresent) $totalHadir++;
                                            @endphp
                                            <td class="px-1 py-4 border-r border-slate-50 text-center {{ \Carbon\Carbon::create($data['year'], $data['month'], $i)->isWeekend() ? 'bg-red-50/30' : '' }}">
                                                @if($isPresent)
                                                    <div class="flex justify-center">
                                                        <div class="w-6 h-6 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-500/20">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-[8px] font-black text-slate-100 tracking-widest uppercase">.</span>
                                                @endif
                                            </td>
                                        @endfor
                                        <td class="px-6 py-4 text-center bg-gold-premium/5">
                                            <span class="px-3 py-1 rounded-full bg-slate-900 text-gold-light text-[10px] font-black">
                                                {{ $totalHadir }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Print Button -->
                    <div class="mt-12 flex justify-center no-print">
                        <button onclick="window.print()" class="group relative px-10 py-4 bg-slate-900 rounded-2xl overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20">
                            <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-gold-light to-gold-dark transition-all group-hover:h-full opacity-20"></div>
                            <div class="relative flex items-center gap-3 text-white font-black uppercase tracking-widest text-[11px]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak Rekapitulasi
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-silk {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
        }

        .text-gold-light { color: #d4af37; }
        .text-gold-dark { color: #b8860b; }
        .bg-gold-light\/10 { background-color: rgba(212, 175, 55, 0.1); }
        .from-gold-light { --tw-gradient-from: #d4af37; }
        .to-gold-dark { --tw-gradient-to: #b8860b; }
        .text-gold-premium { color: #8e6d10; }
        .bg-gold-premium\/10 { background-color: rgba(142, 109, 16, 0.1); }

        @media print {
            @page {
                size: landscape;
                margin: 0.5cm;
            }
            .no-print, form, .mb-12 > form { display: none !important; }
            body { background: white !important; color: black !important; }
            .bg-silk { background: white !important; }
            .shadow-2xl, .shadow-sm, .shadow-xl { box-shadow: none !important; }
            .bg-white\/70, .bg-white\/50, .bg-white { background: white !important; border: 1px solid #eee !important; }
            .py-12, .p-8 { padding: 5px !important; }
            .mb-12 { margin-bottom: 20px !important; }
            .rounded-\[2\.5rem\], .rounded-\[2rem\], .rounded-2xl { border-radius: 0 !important; }
            .sticky { position: static !important; }
            .min-w-\[1200px\] { min-width: 100% !important; width: 100% !important; }
            .overflow-x-auto { overflow: visible !important; }
            
            table { width: 100% !important; border-collapse: collapse !important; font-size: 7pt !important; }
            th, td { border: 1px solid #ddd !important; padding: 2px 4px !important; }
            th { background-color: #f3f4f6 !important; color: black !important; }
            
            .bg-slate-900 { background: #eee !important; color: black !important; }
            .text-gold-light { color: black !important; }
            .text-white\/40 { color: #666 !important; }
            .bg-red-900\/10, .bg-red-50\/30 { background-color: #fef2f2 !important; }
            .bg-emerald-500\/10 { background-color: #ecfdf5 !important; }
            .text-emerald-600 { color: #059669 !important; }
            
            /* Ensure the content takes full width since sidebar is hidden */
            .max-w-\[95\%\], .max-w-7xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
        }
    </style>
</x-app-layout>
