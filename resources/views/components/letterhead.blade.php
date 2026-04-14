@props(['title' => 'Surat Dokumentasi', 'subtitle' => 'Bo To Delpi Document', 'refNumber' => null, 'sppgName' => null])

<div class="border-b-4 border-royal-navy">
    <div class="flex items-center justify-between px-10 pt-8 pb-6">
        <!-- Logo BGN (Kiri) -->
        <div class="flex items-center space-x-3">
            <div class="w-20 h-20 flex items-center justify-center">
                <img src="{{ asset('images/logo-bgn-v2.png') }}" alt="Logo BGN" class="h-full w-auto object-contain">
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
            <div class="w-20 h-20 flex items-center justify-center">
                <img src="{{ asset('images/logo-yayasan-v2.png') }}" alt="Logo Yayasan" class="h-full w-auto object-contain">
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
