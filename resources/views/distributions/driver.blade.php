<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-royal-navy leading-tight tracking-tight uppercase font-playfair">
                {{ __('Driver Dashboard') }}
            </h2>
            <div class="w-2 h-2 rounded-full bg-gold animate-ping"></div>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-md mx-auto space-y-6">
            @if(!$activeRoute)
                <div class="glass p-8 text-center rounded-[2rem] border border-gold/10">
                    <div class="w-20 h-20 bg-silk rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="font-black text-royal-navy uppercase tracking-widest text-lg">Belum Ada Tugas</h3>
                    <p class="text-slate-500 text-xs mt-2 font-bold leading-relaxed">Hubungi asisten lapangan untuk mendapatkan jadwal rute distribusi hari ini.</p>
                </div>
            @else
                <!-- Route Info Card -->
                <div class="premium-card p-6 bg-royal-navy text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gold/5 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-[10px] font-black text-gold-light uppercase tracking-[0.2em] opacity-70">Tugas Hari Ini</p>
                                <h3 class="text-xl font-black mt-1">{{ Carbon\Carbon::parse($activeRoute->date)->format('d F Y') }}</h3>
                            </div>
                            <span class="px-3 py-1 bg-gold text-royal-navy text-[10px] font-black uppercase tracking-wider rounded-full">
                                {{ $activeRoute->status }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-3 text-xs opacity-80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="font-bold">Asisten: {{ $activeRoute->assistant->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Departure Section -->
                @if($activeRoute->status == 'planned')
                    <div class="glass p-8 rounded-[2rem] border-2 border-dashed border-gold/30">
                        <h4 class="text-center font-black text-royal-navy uppercase tracking-[0.2em] mb-6">Siap Berangkat?</h4>
                        <form action="{{ route('distributions.depart', $activeRoute) }}" id="departForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="latitude" id="lat">
                            <input type="hidden" name="longitude" id="lng">
                            <div class="space-y-4">
                                <label class="block text-center cursor-pointer group">
                                    <div class="w-full py-10 bg-silk rounded-2xl border-2 border-transparent group-hover:border-gold transition-all relative overflow-hidden">
                                        <input type="file" name="departure_photo" class="hidden" required onchange="handleDepart(this)">
                                        <svg class="w-10 h-10 text-gold-dark mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <p class="text-[10px] font-black text-royal-navy uppercase tracking-widest">Ambil Foto Berangkat</p>
                                    </div>
                                    <p class="text-[9px] text-slate-400 mt-2 italic font-bold text-center underline decoration-gold/30 underline-offset-4">*Klik untuk buka kamera/galeri</p>
                                </label>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Departure Details -->
                    <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-2xl border border-emerald-100 mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Berangkat Dari SPPG</p>
                                <p class="text-sm font-black text-royal-navy">{{ Carbon\Carbon::parse($activeRoute->departure_time)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($activeRoute->departure_photo) }}" target="_blank" class="text-[10px] font-black text-gold-dark border-b-2 border-gold/30">Lihat Foto</a>
                    </div>

                    <!-- Stops Timeline -->
                    <div class="space-y-4">
                        <h4 class="font-black text-royal-navy uppercase tracking-[0.2em] text-xs pl-2 mb-2">Urutan Pengiriman</h4>
                        @foreach($activeRoute->stops->sortBy('order') as $stop)
                            <div class="relative pl-8 pb-4 last:pb-0">
                                <!-- Line Connector -->
                                @if(!$loop->last)
                                    <div class="absolute left-3.5 top-8 bottom-0 w-0.5 bg-slate-100"></div>
                                @endif
                                
                                <!-- Stop Dot -->
                                <div class="absolute left-0 top-1.5 w-7 h-7 rounded-full border-2 {{ $stop->status == 'completed' ? 'bg-emerald-500 border-emerald-500' : 'bg-white border-gold' }} flex items-center justify-center z-10 transition-colors">
                                    @if($stop->status == 'completed')
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <span class="text-[10px] font-black text-gold-dark">{{ $stop->order }}</span>
                                    @endif
                                </div>

                                <div class="glass p-5 rounded-2xl border border-gold/10 {{ $stop->status == 'completed' ? 'opacity-60 grayscale' : 'shadow-lg shadow-gold/5' }}">
                                    <h5 class="font-black text-royal-navy text-sm uppercase leading-tight">{{ $stop->beneficiaryGroup->name ?? 'Sekolah Tidak Ditemukan' }}</h5>
                                    @if($stop->beneficiaryGroup->latitude && $stop->beneficiaryGroup->longitude)
                                        <a href="https://www.google.com/maps?q={{ $stop->beneficiaryGroup->latitude }},{{ $stop->beneficiaryGroup->longitude }}" target="_blank" class="text-[10px] font-bold text-gold-dark mt-1 mb-4 flex items-center hover:underline">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ Str::limit($stop->beneficiaryGroup->location ?? 'No Address', 30) }} (Lihat di Maps)
                                        </a>
                                    @else
                                        <p class="text-[10px] font-bold text-slate-400 mt-1 mb-4 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ Str::limit($stop->beneficiaryGroup->location ?? 'No Address', 30) }}
                                        </p>
                                    @endif

                                    @if($stop->status == 'pending')
                                        <button onclick="toggleStopModal('{{ $stop->id }}')" class="w-full py-3 bg-royal-navy text-gold text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-royal-navy/90 transition-all flex items-center justify-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>Selesaikan Pengiriman</span>
                                        </button>
                                    @else
                                        <div class="mt-2 flex items-center space-x-2 text-[10px] font-black text-emerald-600">
                                            <span>Tiba Pukul {{ Carbon\Carbon::parse($stop->arrival_time)->format('H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Handover Modal -->
    <div id="handoverModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-royal-navy/90 backdrop-blur-sm"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-[3rem] p-8 animate-slide-up">
            <div class="w-12 h-1.5 bg-slate-100 rounded-full mx-auto mb-8"></div>
            <h3 class="font-black text-xl text-royal-navy uppercase tracking-widest text-center mb-8">Bukti Serah Terima</h3>
            
            <form id="handoverForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <label class="block cursor-pointer group">
                            <div class="h-32 bg-silk rounded-2xl flex flex-col items-center justify-center p-4 text-center border-2 border-transparent group-hover:border-gold transition-all">
                                <input type="file" name="handover_photo" class="hidden" required id="handover_input">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gold-dark mb-2 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <span class="text-[9px] font-black text-royal-navy uppercase tracking-widest">Foto Serah Terima</span>
                                <div id="handover_preview" class="hidden text-[8px] font-bold text-emerald-500 mt-1 uppercase">✓ Foto Terpilih</div>
                            </div>
                        </label>

                        <label class="block cursor-pointer group">
                            <div class="h-32 bg-silk rounded-2xl flex flex-col items-center justify-center p-4 text-center border-2 border-transparent group-hover:border-gold transition-all">
                                <input type="file" name="handover_doc_photo" class="hidden" required id="doc_input">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gold-dark mb-2 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <span class="text-[9px] font-black text-royal-navy uppercase tracking-widest">Foto Dokumen</span>
                                <div id="doc_preview" class="hidden text-[8px] font-bold text-emerald-500 mt-1 uppercase">✓ Foto Terpilih</div>
                            </div>
                        </label>
                    </div>

                    <div class="flex space-x-3 pt-6">
                        <button type="button" onclick="toggleStopModal()" class="flex-1 py-4 bg-silk text-royal-navy font-black text-[10px] uppercase tracking-widest rounded-2xl">Batal</button>
                        <button type="submit" class="flex-[2] py-4 bg-royal-navy text-gold font-black text-[10px] uppercase tracking-widest rounded-2xl shadow-xl shadow-royal-navy/20">Konfirmasi Tiba</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes slide-up {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        .animate-slide-up {
            animation: slide-up 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>

    <script>
        function handleDepart(input) {
            if (input.files.length > 0) {
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        document.getElementById('lat').value = position.coords.latitude;
                        document.getElementById('lng').value = position.coords.longitude;
                        document.getElementById('departForm').submit();
                    }, function(error) {
                        console.error("Error getting location: ", error);
                        document.getElementById('departForm').submit();
                    }, {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    });
                } else {
                    document.getElementById('departForm').submit();
                }
            }
        }

        function toggleStopModal(stopId) {
            const modal = document.getElementById('handoverModal');
            const form = document.getElementById('handoverForm');
            if (stopId) {
                form.action = `/distributions/stops/${stopId}/arrive`;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        document.getElementById('handover_input').onchange = function() {
            if(this.files.length) document.getElementById('handover_preview').classList.remove('hidden');
        };
        document.getElementById('doc_input').onchange = function() {
            if(this.files.length) document.getElementById('doc_preview').classList.remove('hidden');
        };
    </script>
</x-app-layout>
