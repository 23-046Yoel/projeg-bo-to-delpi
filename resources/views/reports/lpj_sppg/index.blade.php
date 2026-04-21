<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-royal-navy uppercase tracking-tight">Daftar BERKAS LPJ SPPG</h2>
                    <a href="{{ route('reports.lpj-sppg.create') }}" class="inline-flex items-center px-4 py-2 bg-royal-navy border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gold transition ease-in-out duration-150">
                        + Buat LPJ Baru
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-silk">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-widest">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-widest">Tgl Laporan</th>
                                <th class="px-6 py-3 text-right text-xs font-black text-gray-500 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($lpjs as $lpj)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                        {{ $lpj->period_start->format('d M Y') }} - {{ $lpj->period_end->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $lpj->report_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('reports.lpj-sppg.show', $lpj) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-bold uppercase tracking-tight">Cetak</a>
                                        <a href="{{ route('reports.lpj-sppg.edit', $lpj) }}" class="text-gold-dark hover:text-gold font-bold uppercase tracking-tight">Edit</a>
                                        <form action="{{ route('reports.lpj-sppg.destroy', $lpj) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold uppercase tracking-tight" onclick="return confirm('Hapus laporan ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 font-bold italic">
                                        Belum ada data LPJ.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
