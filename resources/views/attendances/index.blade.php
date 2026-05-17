<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-playfair font-black text-3xl text-royal-navy leading-tight tracking-tight">
                    {{ __('Laporan Absensi Relawan') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Monitoring Kehadiran STAFF & VOLUNTEER secara Real-time</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('reports.attendance-recap') }}" class="px-5 py-2.5 bg-royal-navy text-gold-light rounded-xl border border-gold/20 flex items-center space-x-2 hover:bg-gold hover:text-white transition-all shadow-lg group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">Lihat Rekap Bulanan</span>
                </a>
                <div class="px-4 py-2 bg-emerald-50 rounded-xl border border-emerald-100 flex items-center space-x-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Sistem Aktif</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center space-x-3 shadow-sm animate-bounce">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl shadow-sm">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm font-black uppercase tracking-wider text-rose-600">Terjadi Kesalahan Input</span>
                    </div>
                    <ul class="list-disc pl-9 text-xs font-bold space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Attendance & Clock Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Geolocation Card -->
                <div class="lg:col-span-1 glass bg-white/70 backdrop-blur-md rounded-[2.5rem] border border-gold/10 p-6 shadow-xl relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gold/5 rounded-full -mr-8 -mt-8 blur-xl"></div>
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[10px] font-black text-royal-navy uppercase tracking-[0.2em] bg-silk px-3 py-1.5 rounded-full border border-royal-navy/10">Presensi Mandiri</span>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <h3 class="font-playfair font-black text-xl text-royal-navy mb-4">Absen Dari Lokasi Sekarang</h3>
                        
                        <form action="{{ route('attendances.store') }}" method="POST" id="attendance-form" class="space-y-4">
                            @csrf
                            <input type="hidden" name="latitude" id="latitude-input" required>
                            <input type="hidden" name="longitude" id="longitude-input" required>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Cabang SPPG / Dapur</label>
                                <select name="sppg_id" class="w-full bg-silk/50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-royal-navy focus:ring-2 focus:ring-gold focus:border-gold transition-all" required>
                                    <option value="" disabled selected>Pilih Lokasi Dapur Anda...</option>
                                    @foreach($sppgs as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Kehadiran</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label id="status-in-label" onclick="selectStatus('in')" class="flex items-center justify-center py-3 bg-emerald-500/10 border-2 border-emerald-500 rounded-xl cursor-pointer transition-all text-center">
                                        <input type="radio" name="status" id="status-in" value="in" class="sr-only" checked>
                                        <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Check In</span>
                                    </label>
                                    <label id="status-out-label" onclick="selectStatus('out')" class="flex items-center justify-center py-3 bg-silk/50 border-2 border-slate-200 rounded-xl cursor-pointer hover:bg-rose-500/10 hover:border-rose-500 transition-all text-center">
                                        <input type="radio" name="status" id="status-out" value="out" class="sr-only">
                                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Check Out</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Alamat Fisik (GPS Terurai)</label>
                                <textarea name="address" id="address-input" rows="2" class="w-full bg-silk/30 border border-slate-200 rounded-xl px-4 py-3 text-[11px] font-bold text-slate-600 leading-relaxed italic cursor-not-allowed" placeholder="Tekan tombol 'Deteksi GPS' untuk memuat alamat lokasi Anda..." readonly></textarea>
                            </div>

                            <div class="pt-2">
                                <button type="button" id="gps-btn" onclick="getGPSLocation()" class="w-full py-3.5 bg-royal-navy text-gold hover:bg-gold hover:text-white transition-all rounded-xl font-black text-xs uppercase tracking-widest border border-gold/20 flex items-center justify-center space-x-2 shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>Deteksi Lokasi GPS Anda</span>
                                </button>
                            </div>

                            <p class="text-[10px] text-center" id="gps-status"><span class="text-slate-400">GPS belum diaktifkan</span></p>

                            <button type="submit" id="submit-attendance-btn" disabled class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white hover:from-emerald-600 hover:to-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all rounded-xl font-black text-xs uppercase tracking-[0.15em] flex items-center justify-center space-x-2 shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Kirim Presensi Sekarang</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Clock & Info Dashboard -->
                <div class="lg:col-span-2 glass bg-royal-navy text-white rounded-[2.5rem] border border-gold/20 p-8 shadow-2xl relative overflow-hidden flex flex-col justify-between">
                    <!-- Premium Background Accent -->
                    <div class="absolute top-0 right-0 w-80 h-80 bg-gold/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-royal-navy/50 rounded-full -ml-16 -mb-16 blur-2xl"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <span class="text-[10px] font-black text-gold uppercase tracking-[0.25em]">Waktu Server Lokal</span>
                                <h4 class="text-xs font-bold text-slate-300 mt-1">Waktu Indonesia Barat (WIB)</h4>
                            </div>
                            <div class="px-4 py-2 bg-white/5 border border-white/10 rounded-2xl flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                <span class="text-[9px] font-black uppercase tracking-widest text-gold">GPS Live Tracking</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <p class="text-sm font-bold text-gold uppercase tracking-[0.2em]" id="live-date">Memuat tanggal...</p>
                            <h2 class="font-playfair font-black text-5xl md:text-6xl text-gold-light tracking-tight leading-none" id="live-time">00:00:00</h2>
                        </div>
                    </div>

                    <div class="relative z-10 mt-8 pt-6 border-t border-white/10 grid grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Koordinator</span>
                            <span class="block text-sm font-black text-gold mt-1">{{ auth()->user()->name }}</span>
                        </div>
                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Hak Akses</span>
                            <span class="block text-sm font-black text-gold mt-1 uppercase">{{ auth()->user()->role ?? 'Relawan' }}</span>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Dapur Default</span>
                            <span class="block text-sm font-black text-gold mt-1">{{ auth()->user()->sppg->name ?? 'Pilih Saat Absen' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function updateClock() {
                    const now = new Date();
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    document.getElementById('live-date').innerText = now.toLocaleDateString('id-ID', options);
                    document.getElementById('live-time').innerText = now.toLocaleTimeString('id-ID');
                }
                setInterval(updateClock, 1000);
                window.addEventListener('DOMContentLoaded', updateClock);

                function selectStatus(status) {
                    const inLabel = document.getElementById('status-in-label');
                    const outLabel = document.getElementById('status-out-label');
                    const inRadio = document.getElementById('status-in');
                    const outRadio = document.getElementById('status-out');

                    if (status === 'in') {
                        inRadio.checked = true;
                        inLabel.className = "flex items-center justify-center py-3 bg-emerald-500/10 border-2 border-emerald-500 rounded-xl cursor-pointer transition-all text-center";
                        inLabel.querySelector('span').className = "text-xs font-black text-emerald-600 uppercase tracking-widest";
                        
                        outLabel.className = "flex items-center justify-center py-3 bg-silk/50 border-2 border-slate-200 rounded-xl cursor-pointer hover:bg-rose-500/10 hover:border-rose-500 transition-all text-center";
                        outLabel.querySelector('span').className = "text-xs font-black text-slate-500 uppercase tracking-widest";
                    } else {
                        outRadio.checked = true;
                        outLabel.className = "flex items-center justify-center py-3 bg-rose-500/10 border-2 border-rose-500 rounded-xl cursor-pointer transition-all text-center";
                        outLabel.querySelector('span').className = "text-xs font-black text-rose-600 uppercase tracking-widest";
                        
                        inLabel.className = "flex items-center justify-center py-3 bg-silk/50 border-2 border-emerald-500 rounded-xl cursor-pointer hover:bg-emerald-500/10 hover:border-emerald-500 transition-all text-center";
                        inLabel.querySelector('span').className = "text-xs font-black text-slate-500 uppercase tracking-widest";
                    }
                }

                function getGPSLocation() {
                    const btn = document.getElementById('gps-btn');
                    const statusText = document.getElementById('gps-status');
                    const latInput = document.getElementById('latitude-input');
                    const lngInput = document.getElementById('longitude-input');
                    const addressInput = document.getElementById('address-input');
                    const submitBtn = document.getElementById('submit-attendance-btn');

                    btn.disabled = true;
                    btn.classList.add('animate-pulse');
                    statusText.innerHTML = `<span class="text-amber-500 font-bold">⏳ Mengambil koordinat GPS...</span>`;

                    if (!navigator.geolocation) {
                        statusText.innerHTML = `<span class="text-red-500 font-bold">❌ Geolocation tidak didukung browser Anda.</span>`;
                        btn.disabled = false;
                        btn.classList.remove('animate-pulse');
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            latInput.value = lat;
                            lngInput.value = lng;

                            statusText.innerHTML = `<span class="text-emerald-500 font-bold">📍 Koordinat diperoleh: ${lat.toFixed(6)}, ${lng.toFixed(6)}</span>`;
                            
                            // Fetch Address via OpenStreetMap Nominatim (Free Reverse Geocoding)
                            statusText.innerHTML += `<br><span class="text-amber-500 font-bold">⏳ Melacak alamat fisik...</span>`;
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                                headers: { 'Accept-Language': 'id-ID,id;q=0.9' }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.display_name) {
                                    addressInput.value = data.display_name;
                                    statusText.innerHTML = `<span class="text-emerald-500 font-bold">✅ Alamat berhasil dilacak!</span>`;
                                } else {
                                    addressInput.value = `Koordinat: ${lat}, ${lng}`;
                                    statusText.innerHTML = `<span class="text-emerald-500 font-bold">✅ Koordinat terkunci (Alamat tidak terurai).</span>`;
                                }
                                submitBtn.disabled = false;
                                btn.disabled = false;
                                btn.classList.remove('animate-pulse');
                            })
                            .catch(err => {
                                addressInput.value = `Koordinat: ${lat}, ${lng}`;
                                statusText.innerHTML = `<span class="text-emerald-500 font-bold">✅ Koordinat terkunci (Gagal menghubungi server peta).</span>`;
                                submitBtn.disabled = false;
                                btn.disabled = false;
                                btn.classList.remove('animate-pulse');
                            });
                        },
                        function(error) {
                            let msg = 'Gagal mengakses GPS';
                            if (error.code === error.PERMISSION_DENIED) {
                                msg = 'Izin lokasi ditolak oleh pengguna. Aktifkan izin lokasi pada browser Anda.';
                            } else if (error.code === error.POSITION_UNAVAILABLE) {
                                msg = 'Informasi lokasi tidak tersedia.';
                            } else if (error.code === error.TIMEOUT) {
                                msg = 'Waktu permintaan lokasi habis.';
                            }
                            statusText.innerHTML = `<span class="text-red-500 font-bold">❌ ${msg}</span>`;
                            btn.disabled = false;
                            btn.classList.remove('animate-pulse');
                        },
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                }
            </script>

            <!-- Filter Tabs -->
            <div class="flex items-center space-x-2 mb-6 overflow-x-auto pb-2 custom-scrollbar">
                <a href="{{ route('attendances.index') }}" 
                   class="px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('sppg_id') ? 'bg-royal-navy text-gold shadow-lg ring-2 ring-gold/20' : 'bg-white text-gray-400 border border-gray-100 hover:bg-silk' }}">
                    SEMUA LOKASI
                </a>
                @foreach($sppgs as $s)
                    <a href="{{ route('attendances.index', ['sppg_id' => $s->id]) }}" 
                       class="px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('sppg_id') == $s->id ? 'bg-royal-navy text-gold shadow-lg ring-2 ring-gold/20' : 'bg-white text-gray-400 border border-gray-100 hover:bg-silk whitespace-nowrap' }}">
                        {{ $s->name }}
                    </a>
                @endforeach
            </div>

            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gold/10 relative">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gold/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                
                <div class="overflow-x-auto custom-scrollbar relative z-10">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-gradient-to-r from-royal-navy to-royal-navy/90">
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Relawan & Cabang</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Waktu Presensi</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Koordinat GPS</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Lokasi / Alamat</th>
                                <th class="px-8 py-6 text-center text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 bg-white/30 backdrop-blur-md">
                            @forelse ($attendances as $attendance)
                                <tr class="hover:bg-gold/5 transition-all duration-300 group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-2xl bg-royal-navy flex items-center justify-center text-gold font-black text-xs shadow-lg group-hover:scale-110 transition-transform duration-500 mr-4">
                                                {{ substr($attendance->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <span class="block text-sm font-black text-royal-navy uppercase tracking-tight">{{ $attendance->user->name }}</span>
                                                <div class="flex items-center space-x-1.5 mt-0.5">
                                                    <span class="text-[9px] font-bold text-gold-dark uppercase tracking-widest">{{ $attendance->user->role ?? 'Relawan' }}</span>
                                                    <span class="text-[9px] font-bold text-gray-300">•</span>
                                                    <span class="text-[9px] font-black text-royal-navy/60 uppercase tracking-widest px-1.5 py-0.5 bg-silk rounded border border-royal-navy/10">{{ $attendance->sppg->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-royal-navy">{{ $attendance->created_at->translatedFormat('d M Y') }}</span>
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $attendance->created_at->format('H:i') }} WIB</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" 
                                           target="_blank" 
                                           class="inline-flex items-center px-4 py-2 bg-silk border border-gold/10 rounded-xl text-xs font-black text-royal-navy hover:bg-gold hover:text-white transition-all shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            MAPS
                                        </a>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="max-w-xs">
                                            <p class="text-[11px] font-bold text-slate-600 leading-relaxed italic line-clamp-1">
                                                {{ $attendance->address ?? 'Lokasi GPS Tercatat' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $attendance->status == 'in' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                                            {{ $attendance->status == 'in' ? 'Check In' : 'Check Out' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-silk rounded-[2rem] flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Belum ada data absensi yang tercatat hari ini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-[10px] font-black text-slate-400 tracking-wide uppercase">
                        TOTAL RECORD: <span class="text-royal-navy">{{ $attendances->total() }}</span> PRESENSI
                    </p>
                    <div class="premium-pagination">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
