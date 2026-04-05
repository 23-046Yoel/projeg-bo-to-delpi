<x-app-layout>
    <div class="py-12 bg-[#0a192f] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-xl overflow-hidden shadow-2xl rounded-3xl border border-white/10 p-10">
                <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                    <div>
                        <h2 class="text-4xl font-serif text-[#d4af37] tracking-widest mb-2">Laporan Arus Kas</h2>
                        <p class="text-gray-400 font-light">Laporan Ledger Keuangan: Masuk, Keluar, dan Saldo (VA & Kas di Tangan).</p>
                    </div>
                    <div class="bg-white/5 p-4 rounded-2xl border border-[#d4af37]/20 flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Saldo Berjalan</p>
                            <p class="text-2xl font-serif text-[#d4af37]">Rp {{ number_format($balance) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-[#d4af37]/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#d4af37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 bg-white/5 p-6 rounded-2xl border border-white/5">
                    <div>
                        <label class="block text-[10px] font-bold text-[#d4af37] uppercase tracking-widest mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-navy-900 border-white/10 text-white rounded-xl focus:ring-[#d4af37] focus:border-[#d4af37]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#d4af37] uppercase tracking-widest mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-navy-900 border-white/10 text-white rounded-xl focus:ring-[#d4af37] focus:border-[#d4af37]">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-[#d4af37] text-navy-900 py-3 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-[#c19b2e] transition-all shadow-lg shadow-[#d4af37]/20">
                            Apply Filter
                        </button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/10">
                                <th class="px-6 py-4 text-[10px] font-bold text-[#d4af37] uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-[#d4af37] uppercase tracking-widest">Keterangan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-[#d4af37] uppercase tracking-widest">Jenis</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-[#d4af37] uppercase tracking-widest text-right">Masuk</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-[#d4af37] uppercase tracking-widest text-right">Keluar</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-[#d4af37] uppercase tracking-widest text-right">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @php $runningBalance = $balance; @endphp
                            @foreach($transactions as $tx)
                            @php 
                                $runningBalance += ($tx->amount_in - $tx->amount_out);
                            @endphp
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4 text-gray-400 text-xs">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/y') }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-white text-sm font-medium">{{ $tx->notes }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-tighter">{{ $tx->cash_type }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-[10px] bg-white/5 px-3 py-1 rounded-full text-gray-400 uppercase tracking-widest">{{ $tx->transaction_type }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="{{ $tx->amount_in > 0 ? 'text-emerald-400 font-bold' : 'text-gray-600' }}">
                                        {{ $tx->amount_in > 0 ? '+'.number_format($tx->amount_in) : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="{{ $tx->amount_out > 0 ? 'text-rose-400 font-bold' : 'text-gray-600' }}">
                                        {{ $tx->amount_out > 0 ? '-'.number_format($tx->amount_out) : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-white font-serif font-bold italic">
                                    {{ number_format($runningBalance) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
