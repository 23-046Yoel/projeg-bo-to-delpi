@props(['title' => 'Surat Dokumentasi', 'subtitle' => 'Bo To Delpi Document', 'refNumber' => null, 'sppgName' => null])

<div class="border-b-4 border-royal-navy">
    <div class="flex items-center justify-between px-10 pt-8 pb-6">
        <!-- Logo BGN (Kiri) -->
        <div class="flex items-center space-x-3">
            <div class="w-16 h-16 rounded-full bg-royal-navy flex items-center justify-center shadow-lg">
                <svg class="w-9 h-9 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight">Badan Gizi Nasional</p>
                <p class="text-[9px] font-bold text-gray-400 tracking-wide">National Nutrition Agency</p>
            </div>
        </div>

        <!-- Judul Tengah -->
        <div class="text-center flex-1 px-4">
            <h1 class="text-lg font-black text-royal-navy uppercase tracking-widest">SPPG {{ $sppgName ?? (auth()->user()->sppg->name ?? 'ALAD ELPHI') }}</h1>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.15em] mt-0.5">Satuan Pelayanan Pemenuhan Gizi</p>
            <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Program Makan Bergizi Gratis (MBG)</p>
        </div>

        <!-- Logo Yayasan (Kanan) -->
        <div class="flex items-center space-x-3">
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight text-right">Yayasan Alad Elphi</p>
                <p class="text-[9px] font-bold text-gray-400 tracking-wide text-right">Foundation</p>
            </div>
            <div class="w-16 h-16 rounded-full bg-gold flex items-center justify-center shadow-lg">
                <svg class="w-9 h-9 text-royal-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Sub-header strip -->
    <div class="bg-royal-navy px-10 py-2 flex justify-between items-center">
        <p class="text-[9px] font-bold text-gold/80 uppercase tracking-widest">{{ $title }}</p>
        @if($refNumber)
            <p class="text-[9px] font-bold text-gold/80 uppercase tracking-widest">No: {{ $refNumber }}</p>
        @endif
    </div>
</div>
