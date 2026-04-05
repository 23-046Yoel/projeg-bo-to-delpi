<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-playfair font-black text-3xl text-royal-navy leading-tight tracking-tight">
                    {{ __('Distribution Routes') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">Monitor and plan food distribution routes for schools.</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('distributions.create') }}" class="btn-premium scale-90 md:scale-100">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Susun Rute Baru</span>
                    </span>
                </a>
                <div class="relative hidden md:block">
                    <input type="text" id="mapSearch" onkeyup="searchOnMap(this.value)" placeholder="Cari di Peta..." class="bg-white/80 border-slate-100 rounded-xl px-4 py-2.5 text-xs font-bold text-royal-navy focus:ring-gold focus:border-gold w-64 shadow-sm">
                    <svg class="w-4 h-4 absolute right-3 top-3 text-slate-400 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Map Visualization -->
            <div class="mb-10 animate-fade-in" style="animation-delay: 0.2s">
                <div class="flex items-center mb-6 space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-royal-navy flex items-center justify-center text-gold shadow-lg shadow-royal-navy/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-royal-navy uppercase tracking-widest text-sm">Visualisasi Lokasi & Rute</h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Pantau persebaran sekolah penerima manfaat</p>
                    </div>
                </div>
                
                <div class="glass p-4 rounded-[2.5rem] border border-gold/10 overflow-hidden shadow-2xl relative">
                    <div id="routeMap" class="w-full h-[450px] rounded-[2rem] z-10 border border-slate-100"></div>
                </div>
            </div>
            <!-- Location List Overview -->
            <div class="mb-10 animate-fade-in" style="animation-delay: 0.4s">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-gold flex items-center justify-center text-royal-navy shadow-lg shadow-gold/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-royal-navy uppercase tracking-widest text-sm">Daftar Titik Lokasi Penerima</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Seluruh sekolah di bawah naungan SPPG Anda</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($schools as $school)
                        <div class="glass p-6 rounded-[2rem] border border-gold/10 hover:border-gold/30 transition-all duration-300 group shadow-lg hover:shadow-gold/5">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-silk border border-gold/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <span id="school-count-{{ $school->id }}" class="school-counter text-xs font-black text-royal-navy" data-original="{{ $loop->iteration }}">{{ $loop->iteration }}</span>
                                </div>
                                <a href="https://www.google.com/maps?q={{ $school->latitude }},{{ $school->longitude }}" target="_blank" class="p-2 rounded-xl bg-royal-navy text-gold hover:bg-royal-navy/90 transition-colors shadow-md shadow-royal-navy/10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                            
                            <h4 class="font-black text-royal-navy text-sm uppercase leading-snug mb-2 group-hover:text-gold-dark transition-colors">{{ $school->name }}</h4>
                            <p class="text-[10px] font-bold text-slate-500 mb-4 line-clamp-1 flex items-center">
                                <svg class="w-3 h-3 mr-1 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $school->location }}
                            </p>
                            
                            <div class="flex items-center space-x-3 pt-4 border-t border-slate-100/50">
                                <div class="bg-silk/50 px-3 py-1.5 rounded-lg border border-gold/5">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter block leading-none mb-1">Lat</span>
                                    <span class="text-[10px] font-bold text-royal-navy">{{ number_format($school->latitude, 6) }}</span>
                                </div>
                                <div class="bg-silk/50 px-3 py-1.5 rounded-lg border border-gold/5">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter block leading-none mb-1">Long</span>
                                    <span class="text-[10px] font-bold text-royal-navy">{{ number_format($school->longitude, 6) }}</span>
                                </div>
                                <div id="school-qty-container-{{ $school->id }}" class="hidden bg-gold/10 px-3 py-1.5 rounded-lg border border-gold/20 flex-1">
                                    <span class="text-[9px] font-black text-gold-dark uppercase tracking-tighter block leading-none mb-1">Qty Porsi</span>
                                    <span id="school-qty-{{ $school->id }}" class="text-[10px] font-black text-royal-navy">0</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full glass p-12 rounded-[2.5rem] border border-dashed border-gold/20 flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 rounded-full bg-silk border border-gold/10 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gold/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            </div>
                            <h4 class="font-black text-royal-navy uppercase tracking-widest text-sm mb-1">Belum ada titik lokasi</h4>
                            <p class="text-xs font-bold text-slate-400">Tambahkan lokasi sekolah di menu Manajemen Sekolah.</p>
                        </div>
                    @endforelse
                </div>
            </div>

                <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-royal-navy flex items-center justify-center text-gold shadow-lg shadow-royal-navy/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4 4l-4-4m4 4l4-4"/></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-royal-navy uppercase tracking-widest text-sm">Monitor Rute Spesifik</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Pilih rute untuk fokus pada urutan pengantaran</p>
                        </div>
                    </div>
                    
                    <select id="routeSelector" onchange="focusOnRoute(this.value)" class="bg-white border-slate-100 rounded-xl px-4 py-2.5 text-xs font-black text-royal-navy focus:ring-gold focus:border-gold w-full md:w-64 shadow-sm uppercase tracking-wider">
                        <option value="">-- PILIH RUTE AKTIF --</option>
                        @foreach($routes->where('status', '!=', 'completed') as $r)
                            <option value="{{ $r->id }}">RUTE {{ $r->driver->name }} ({{ Carbon\Carbon::parse($r->date)->format('d M') }})</option>
                        @endforeach
                    </select>
                </div>

            <div class="glass overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gold/10 relative animate-fade-in" style="animation-delay: 0.8s">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-royal-navy">
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Tanggal</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Driver</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Assistant</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Stops</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Total Porsi</th>
                                <th class="px-8 py-6 text-left text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Status</th>
                                <th class="px-8 py-6 text-right text-[10px] font-black text-gold-light uppercase tracking-[0.2em]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 bg-white/30">
                            @foreach ($routes as $route)
                                <tr class="hover:bg-gold/5 transition-all duration-300 group">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-sm font-bold text-royal-navy">{{ Carbon\Carbon::parse($route->date)->format('d M Y') }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-silk border border-gold/20 flex items-center justify-center mr-3">
                                                <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            </div>
                                            <span class="text-sm font-bold text-royal-navy">{{ $route->driver->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-xs font-bold text-slate-600">{{ $route->assistant->name }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-lg bg-silk text-[10px] font-black text-royal-navy border border-gold/10">
                                            {{ $route->stops->count() }} Lokasi
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-sm font-black text-royal-navy">{{ number_format($route->stops->sum('quantity')) }}</span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'planned' => 'bg-blue-50 text-blue-600',
                                                'active' => 'bg-gold/10 text-gold-dark animate-pulse',
                                                'completed' => 'bg-emerald-50 text-emerald-600'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusColors[$route->status] }}">
                                            {{ $route->status }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right">
                                        <!-- Add actions if needed -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-400 tracking-wide uppercase">
                        Showing <span class="text-royal-navy">{{ $routes->firstItem() }}</span> to <span class="text-royal-navy">{{ $routes->lastItem() }}</span> of <span class="text-royal-navy">{{ $routes->total() }}</span> routes
                    </p>
                    <div class="premium-pagination">
                        {{ $routes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 1rem !important;
            padding: 0.5rem !important;
            border: 1px solid rgba(212, 175, 55, 0.2) !important;
        }
        .leaflet-popup-tip-container { display: none !important; }
        .school-popup b { color: #002349; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
        .school-popup p { color: #64748b; font-size: 0.7rem; margin-top: 0.25rem; font-weight: bold; }
        .school-static-label {
            background-color: white;
            border: 1px solid #002349;
            border-radius: 6px;
            padding: 2px 6px;
            font-weight: 900;
            font-size: 8px;
            white-space: nowrap;
            color: #002349;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transform: translate(-50%, -20px);
            pointer-events: none;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            z-index: 1000;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($sppg)
                const centerLat = {{ $sppg->latitude }};
                const centerLng = {{ $sppg->longitude }};
            @elseif(count($schools) > 0)
                const centerLat = {{ $schools[0]->latitude }};
                const centerLng = {{ $schools[0]->longitude }};
            @else
                const centerLat = -2.973; // Fallback to a default location
                const centerLng = 104.764;
            @endif

            const map = L.map('routeMap').setView([centerLat, centerLng], 14);
            
            L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // SPPG Home Icon
            const homeIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style='background-color:#002349; border:3px solid #D4AF37; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-center; color:white; box-shadow:0 10px 20px rgba(0,35,73,0.3); line-height:34px; text-align:center;'>
                        <svg style='width:20px; height:20px; display:inline-block; vertical-align:middle' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                       </div>`,
                iconSize: [40, 40],
                iconAnchor: [20, 20]
            });

            // Add all available SPPG markers
            @foreach($allSppgs as $s)
                L.marker([{{ $s->latitude }}, {{ $s->longitude }}], {icon: homeIcon})
                    .addTo(map)
                    .bindPopup({!! json_encode('<div class="school-popup"><b>SPPG ' . e($s->name) . '</b><p>Hulu Pusat Distribusi</p></div>') !!})
                    {{ $sppg && $s->id == $sppg->id ? '.openPopup()' : '' }};
            @endforeach

            // Map Search Function
            window.searchOnMap = function(query) {
                if(!query) return;
                const searchLower = query.toLowerCase();
                @foreach($schools as $school)
                    if(@js(strtolower($school->name)).includes(searchLower)) {
                        map.setView([{{ $school->latitude }}, {{ $school->longitude }}], 16);
                        if(typeof marker_{{ $school->id }} !== 'undefined') {
                            marker_{{ $school->id }}.openPopup();
                        }
                        return;
                    }
                @endforeach
            };

            // Highlight selected route on map
            let currentRouteLine = null;
            let currentRouteMarkers = [];

            window.focusOnRoute = function(routeId) {
                // Clear existing route line
                if(currentRouteLine) map.removeLayer(currentRouteLine);
                currentRouteMarkers.forEach(m => map.removeLayer(m));
                currentRouteMarkers = [];

                if(!routeId) {
                    // Show all original markers
                    @foreach($schools as $school)
                        if(typeof marker_{{ $school->id }} !== 'undefined') {
                            marker_{{ $school->id }}.addTo(map);
                            const span = document.getElementById(`school-count-{{ $school->id }}`);
                            const qtyContainer = document.getElementById(`school-qty-container-{{ $school->id }}`);
                            if(span) {
                                span.innerText = span.getAttribute('data-original');
                                span.parentElement.parentElement.parentElement.classList.remove('opacity-30', 'border-gold');
                            }
                            if(qtyContainer) qtyContainer.classList.add('hidden');
                        }
                    @endforeach
                    return;
                }

                // Get route data
                const routesData = {
                    @foreach($routes as $r)
                        @js((string)$r->id): [
                            @foreach($r->stops->sortBy('order') as $stop)
                                {
                                    id: @js((string)$stop->beneficiary_id),
                                    lat: {{ $stop->beneficiaryGroup->latitude ?? 0 }},
                                    lng: {{ $stop->beneficiaryGroup->longitude ?? 0 }},
                                    name: @js($stop->beneficiaryGroup->name ?? 'Unknown'),
                                    order: @js((string)$stop->order),
                                    qty: @js((string)$stop->quantity)
                                },
                            @endforeach
                        ],
                    @endforeach
                };

                const stops = routesData[routeId];
                if(!stops || stops.length === 0) return;

                // Hide all original markers
                @foreach($schools as $school)
                    if(typeof marker_{{ $school->id }} !== 'undefined') {
                        map.removeLayer(marker_{{ $school->id }});
                    }
                @endforeach

                const latlngs = [];
                
                // Add Start Point (Kitchen) to the polyline first
                @if($sppg)
                    latlngs.push([{{ $sppg->latitude }}, {{ $sppg->longitude }}]);
                @endif

                stops.forEach((stop, index) => {
                    if(stop.lat === 0) return;
                    latlngs.push([stop.lat, stop.lng]);

                    // Add numbered marker
                    const numberedIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color:#D4AF37; color:#002349; width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-center; font-weight:900; font-size:10px; border:2px solid #002349">${stop.order}</div>`,
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    });

                    const m = L.marker([stop.lat, stop.lng], {icon: numberedIcon})
                        .addTo(map)
                        .bindPopup(`<b>${stop.name}</b><br>Urutan: ${stop.order}`);
                    currentRouteMarkers.push(m);
                });

                // Draw line
                currentRouteLine = L.polyline(latlngs, {color: '#D4AF37', weight: 4, dashArray: '5, 10', opacity: 0.8}).addTo(map);
                map.fitBounds(currentRouteLine.getBounds(), {padding: [50, 50]});

                // Update cards UI to focus on route
                document.querySelectorAll('.school-counter').forEach(span => {
                    span.innerText = "-";
                    span.parentElement.parentElement.parentElement.classList.add('opacity-30');
                });

                stops.forEach(stop => {
                    const span = document.getElementById(`school-count-${stop.id}`);
                    const qtyContainer = document.getElementById(`school-qty-container-${stop.id}`);
                    const qtySpan = document.getElementById(`school-qty-${stop.id}`);
                    
                    if(span) {
                        span.innerText = stop.order;
                        span.parentElement.parentElement.parentElement.classList.remove('opacity-30');
                        span.parentElement.parentElement.parentElement.classList.add('border-gold');
                    }
                    if(qtyContainer && qtySpan) {
                        qtyContainer.classList.remove('hidden');
                        qtySpan.innerText = stop.qty;
                    }
                });
            };

            // School Markers
            @foreach($schools as $school)
                const marker_{{ $school->id }} = L.circleMarker([{{ $school->latitude }}, {{ $school->longitude }}], {
                    radius: 8,
                    fillColor: "#D4AF37",
                    color: "#002349",
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                })
                .addTo(map)
                .bindPopup({!! json_encode('<div class="school-popup"><b>' . e($school->name) . '</b><p>' . e($school->location) . '</p></div>') !!});

                // Permanent School Label
                L.marker([{{ $school->latitude }}, {{ $school->longitude }}], {
                    icon: L.divIcon({
                        className: 'school-label-container',
                        html: `<div class="school-static-label">{{ $school->name }}</div>`,
                        iconSize: [0, 0],
                        iconAnchor: [0, 0]
                    }),
                    interactive: false
                }).addTo(map);
            @endforeach

            // Initial call if needed
        });
    </script>
</x-app-layout>
