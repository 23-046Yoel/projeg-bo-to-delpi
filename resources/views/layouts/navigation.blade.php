<!-- Backdrop (Mobile only) -->
<div 
    x-show="sidebarOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-royal-navy/60 backdrop-blur-sm z-40 lg:hidden no-print"
    style="display: none;"
></div>

<nav 
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed lg:static top-0 left-0 w-72 h-full min-h-screen bg-white border-r border-gold/20 flex flex-col z-50 shadow-[20px_0_50px_rgba(0,0,0,0.02)] lg:translate-x-0 no-print"
    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
    x-cloak
    @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true"
    x-init="if (window.innerWidth >= 1024) sidebarOpen = true"
>
    <!-- Close button (Mobile only) -->
    <button @click="sidebarOpen = false" class="lg:hidden absolute top-4 right-4 p-2 text-gold-dark hover:text-gold transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Sidebar Branding -->
    <div class="h-32 flex flex-col items-center justify-center border-b border-gold/10 px-6 bg-gradient-to-b from-white to-gold-soft/10">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center group transition-transform duration-500 hover:scale-105">
            <x-application-logo />
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-8 space-y-2 custom-scrollbar">
        <div class="px-8 mb-6">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Operational Menu</p>
        </div>

        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="group py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Dashboard') }}</span>
        </x-nav-link>

        @can('manage-suppliers')
        <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Suppliers') }}</span>
        </x-nav-link>
        @endcan

        @can('manage-menus')
        <x-nav-link :href="route('menus.index')" :active="request()->routeIs('menus.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Perencanaan Menu') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('dishes.index')" :active="request()->routeIs('dishes.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Daftar Hidangan (Resep)') }}</span>
        </x-nav-link>
        @endcan

        @can('manage-distribution')
        <div class="px-8 mt-4 mb-2">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">Beneficiaries Management</p>
        </div>

        <x-nav-link :href="route('beneficiary-groups.index')" :active="request()->routeIs('beneficiary-groups.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Manajemen Penerima Manfaat') }}</span>
        </x-nav-link>
        @endcan

        @can('manage-beneficiaries')
        <x-nav-link :href="route('beneficiaries.index')" :active="request()->routeIs('beneficiaries.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Daftar PM Detail') }}</span>
        </x-nav-link>
        @endcan

        @can('manage-materials')
        <div class="px-8 mt-4 mb-2">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">Supply Chain</p>
        </div>
        <x-nav-link :href="route('materials.index')" :active="request()->routeIs('materials.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Bahan Baku') }}</span>
        </x-nav-link>
        @endcan

        @can('manage-warehouse')
        <x-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Gudang & Stok') }}</span>
        </x-nav-link>
        @endcan

        @can('manage-finances')
        <div class="px-8 mt-4 mb-2">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">Financial & Recap</p>
        </div>

        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Surat Pesanan') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Input Transaksi') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('financial.index')" :active="request()->routeIs('financial.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Laporan Arus Kas') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('reports.lpd2m')" :active="request()->routeIs('reports.lpd2m')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('LPD2M (MBG)') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('reports.sptj')" :active="request()->routeIs('reports.sptj')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('SPTJ') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('reports.bapsd')" :active="request()->routeIs('reports.bapsd')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('BAPSD') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('reports.upload')" :active="request()->routeIs('reports.upload')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Upload Berkas Resume') }}</span>
        </x-nav-link>
        @endcan

        @can('view-general-reports')
        <div class="px-8 mt-4 mb-2">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">General Reports</p>
        </div>
        <x-nav-link :href="route('attendances.index')" :active="request()->routeIs('attendances.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Laporan Absensi Map') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('reports.attendance-recap')" :active="request()->routeIs('reports.attendance-recap')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 9l2 2 4-4"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Rekap Kehadiran Relawan') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('complaints.index')" :active="request()->routeIs('complaints.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Layanan Pengaduan') }}</span>
        </x-nav-link>
        @endcan
        
        <div class="px-8 mt-4 mb-2">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">Services & Reporting</p>
        </div>
        <x-nav-link :href="route('nutrition.consultation')" :active="request()->routeIs('nutrition.consultation')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Konsultasi Gizi') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('reports.daily')" :active="request()->routeIs('reports.daily')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Laporan Harian') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('nutrition.consultation.list')" :active="request()->routeIs('nutrition.consultation.list')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Data Pendaftar Gizi') }}</span>
        </x-nav-link>

        @can('manage-system')
        <div class="px-8 mt-4 mb-2">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">System Admin</p>
        </div>
        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Manajemen Staff') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('aspirations.index')" :active="request()->routeIs('aspirations.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Moderasi Aspirasi') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3v5h5M7 12h10M7 16h10"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Manajemen Berita') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('distributions.index')" :active="request()->routeIs('distributions.*')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Monitoring Rute') }}</span>
        </x-nav-link>
        @endcan

        @auth
        @if(auth()->user()->role === \App\Models\User::ROLE_DRIVER)
        <x-nav-link :href="route('distributions.driver')" :active="request()->routeIs('distributions.driver')" class="py-3">
            <svg class="w-5 h-5 mr-4" :class="active ? 'text-gold' : 'text-gray-400 group-hover:text-gold'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1-1v10a1 1 0 001 1h1m8-1a1 1 0 011 1v2a1 1 0 01-1 1h-1m-4-14H5a1 1 0 00-1 1v2a1 1 0 001 1h1m12 0h4a1 1 0 011 1v4a1 1 0 01-1 1h-1m-4 7h1"/>
            </svg>
            <span class="font-bold tracking-tight">{{ __('Dashboard Driver') }}</span>
        </x-nav-link>
        @endif
        @endauth
    </div>

    <!-- User Profile & Footer Section -->
    <div class="p-8 border-t border-gold/10 bg-silk">
        @auth
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-royal-navy flex items-center justify-center text-white font-bold shadow-lg ring-4 ring-gold/10">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-black text-royal-navy truncate uppercase tracking-tight">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gold-dark font-bold uppercase tracking-widest">{{ Auth::user()->role_title }}</p>
            </div>
        </div>

        <div class="space-y-3">
            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-xs font-black text-gray-700 hover:text-gold hover:bg-white rounded-xl shadow-sm hover:shadow-md transition-all border border-transparent hover:border-gold/10 uppercase tracking-widest">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ __('Settings') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-xs font-black text-red-600 hover:bg-white rounded-xl shadow-sm hover:shadow-md transition-all border border-transparent hover:border-red-100 uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
        @else
        <div class="space-y-3">
            <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-4 text-xs font-black text-white bg-royal-navy hover:bg-gold rounded-2xl shadow-lg transition-all uppercase tracking-[0.2em]">
                {{ __('Login to System') }}
            </a>
            <p class="text-[9px] text-gray-400 text-center font-bold uppercase tracking-widest">Akses terbatas untuk staff</p>
        </div>
        @endauth
    </div>
</nav>
