<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payments (SPP)') }}
            </h2>
            <a href="{{ route('payments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Payment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden shadow-2xl sm:rounded-2xl border border-gold/20">
                <div class="p-6 text-gray-200">
                    <table class="min-w-full divide-y divide-gray-800">
                        <thead class="bg-black/40">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-widest">Beneficiary</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-widest">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-widest">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($payments as $payment)
                                <tr class="hover:bg-gold/5 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $payment->beneficiary->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $payment->date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap uppercase">
                                        <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full {{ $payment->status == 'paid' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                            {{ $payment->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('payments.edit', $payment) }}" class="text-gold hover:text-white transition font-semibold">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
