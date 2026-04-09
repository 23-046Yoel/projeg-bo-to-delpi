<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                    {{ __('Input Transaksi') }}
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Catatan Riwayat Keuangan SPPG</p>
            </div>
            <a href="{{ route('payments.create') }}" class="py-4 px-8 bg-royal-navy text-gold font-black text-[10px] uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-royal-navy/20 hover:-translate-y-1 transition-all">
                + Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden relative">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-silk/50">
                                <th class="px-8 py-6 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Tanggal</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Keterangan</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Jenis</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-royal-navy uppercase tracking-widest">Kas</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-emerald-600 uppercase tracking-widest">Masuk (+)</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-rose-600 uppercase tracking-widest">Keluar (-)</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-royal-navy uppercase tracking-widest">Selisih</th>
                                <th class="px-8 py-6 text-center text-[10px] font-black text-royal-navy uppercase tracking-widest">Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @foreach($payments as $payment)
                            <tr class="hover:bg-silk/30 transition-colors">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xs font-bold text-royal-navy">{{ \Carbon\Carbon::parse($payment->date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-xs font-bold text-royal-navy line-clamp-2 max-w-xs">{{ $payment->description }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="px-3 py-1 bg-royal-navy/5 text-royal-navy text-[9px] font-black rounded-full uppercase tracking-widest">
                                        {{ $payment->transaction_type }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="px-3 py-1 bg-gold/10 text-gold-dark text-[9px] font-black rounded-full uppercase tracking-widest">
                                        {{ $payment->cash_type }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <div class="text-xs font-black text-emerald-500">
                                        {{ $payment->amount_in > 0 ? '+ '.number_format($payment->amount_in) : '-' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <div class="text-xs font-black text-rose-500">
                                        {{ $payment->amount_out > 0 ? '- '.number_format($payment->amount_out) : '-' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <div class="text-xs font-black text-royal-navy font-playfair">Rp {{ number_format($payment->balance) }}</div>
                                </td>
                                <td class="px-8 py-6 text-center whitespace-nowrap">
                                    @if($payment->proof_file)
                                        <a href="{{ Storage::url($payment->proof_file) }}" target="_blank" class="p-2 bg-silk rounded-xl text-royal-navy hover:text-gold transition-colors inline-block">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        </a>
                                    @else
                                        <span class="text-[9px] font-bold text-gray-300 uppercase italic">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-silk/30 border-t border-gray-100">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
