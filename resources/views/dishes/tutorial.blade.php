<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-white">
            <div>
                <h2 class="font-black playfair italic text-3xl leading-tight">
                    Tutorial: {{ $dish->name }}
                </h2>
                <p class="text-xs uppercase tracking-[0.3em] font-bold text-gray-400 mt-1">Langkah Demi Langkah Gizi Sempurna</p>
            </div>
            <a href="{{ route('dishes.index') }}" class="px-4 py-2 bg-gray-800 text-xs font-black uppercase tracking-widest rounded-lg border border-gray-700 hover:bg-gray-700 transition-all">
                Kembali
            </a>
        </div>
    </x-slot>

    <style>
        .playfair { font-family: 'Playfair Display', serif; }
        .tutorial-card { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        .tutorial-card:hover { transform: translateY(-8px); border-color: #D4AF37; }
        .step-number { text-shadow: 2px 2px 0px rgba(212, 175, 55, 0.3); }
    </style>

    <div class="py-12 bg-[#F8FAFC]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Video / Thumbnail -->
            <div class="mb-12 rounded-[2.5rem] overflow-hidden shadow-2xl bg-black aspect-video relative group">
                @php
                    $youtube_id = null;
                    if ($dish->recipes->first() && $dish->recipes->first()->youtube_url) {
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $dish->recipes->first()->youtube_url, $match);
                        $youtube_id = $match[1] ?? null;
                    }
                @endphp
                
                @if($youtube_id)
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtube_id }}" frameborder="0" allowfullscreen></iframe>
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 to-slate-800 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-[#D4AF37] rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"/></svg>
                            </div>
                            <p class="text-gray-400 font-black text-xs uppercase tracking-widest">Video Tutorial Belum Tersedia</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Ingredients Summary -->
            <div class="mb-16 grid grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100">
                    <h3 class="playfair font-black italic text-xl mb-6 text-gray-900">Bahan Utama</h3>
                    <ul class="space-y-4">
                        @foreach($dish->recipes as $recipe)
                        <li class="flex items-center gap-4 group">
                            <div class="w-2 h-2 rounded-full bg-[#D4AF37] group-hover:scale-150 transition-all"></div>
                            <div class="flex-1">
                                <p class="text-sm font-black text-gray-800">{{ $recipe->material->name }}</p>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $recipe->quantity }} {{ $recipe->unit }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-[#0F172A] p-8 rounded-[2rem] shadow-xl border border-slate-800 flex flex-col justify-center">
                    <h3 class="playfair font-black italic text-xl mb-2 text-[#D4AF37]">Pesan Nutrisi</h3>
                    <p class="text-gray-400 text-sm leading-relaxed italic">"Setiap takaran bahan telah dihitung untuk memenuhi standar gizi 4 sehat 5 sempurna bagi tumbuh kembang optimal."</p>
                    <div class="mt-6 flex gap-2">
                        <span class="px-3 py-1 bg-white/10 rounded-full text-[10px] font-black uppercase text-white tracking-widest">High Protein</span>
                        <span class="px-3 py-1 bg-white/10 rounded-full text-[10px] font-black uppercase text-white tracking-widest">Fresh Local</span>
                    </div>
                </div>
            </div>

            <!-- Narrative Steps -->
            <div class="space-y-12">
                <h3 class="playfair font-black italic text-3xl mb-8 text-center text-gray-900">Prosedur Memasak</h3>
                
                @php
                    $steps = $dish->recipes->first()->steps ?? [];
                    if (is_string($steps)) $steps = json_decode($steps, true);
                    
                    // Fallback if no steps found
                    if (empty($steps)) {
                        $steps = [
                            'Persiapkan semua bahan baku yang telah dicuci bersih.',
                            'Lakukan pengolahan sesuai standar higienitas dapur SPPG.',
                            'Masak dengan suhu yang tepat untuk menjaga kandungan nutrisi.',
                            'Sajikan segera ke dalam wadah distribusi MBG.'
                        ];
                    }
                @endphp

                @foreach($steps as $index => $step)
                <div class="tutorial-card bg-white p-10 rounded-[2.5rem] shadow-xl border-l-8 border-[#D4AF37] relative flex gap-8 items-start">
                    <div class="step-number playfair text-6xl font-black italic text-[#D4AF37]/20 absolute top-4 right-8 select-none">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0 shadow-lg font-black text-xl">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 pt-2">
                        <p class="text-lg text-gray-700 leading-relaxed font-medium">
                            {{ $step }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Closure -->
            <div class="mt-20 text-center p-12 bg-white rounded-[3rem] shadow-2xl border border-gray-100">
                <div class="w-16 h-1 bg-[#D4AF37] mx-auto mb-8"></div>
                <h4 class="playfair font-black italic text-2xl mb-4">Siap Disajikan</h4>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto font-medium">Pastikan kualitas rasa dan kebersihan terjaga sebelum makanan masuk ke proses logistik.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('distributions.create') }}" class="px-8 py-4 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all">Mulai Distribusi</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
