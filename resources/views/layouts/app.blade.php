<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Scripts & AlpineJS (Loaded in head to avoid x-cloak lock on mobile) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Tailwind CDN Fallback -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--single {
                background-color: #F8FAFC;
                border: 2px solid transparent;
                border-radius: 1rem;
                height: 56px;
                display: flex;
                align-items: center;
                padding-left: 1rem;
                font-weight: 700;
                font-size: 0.875rem;
                color: #0F172A;
                transition: all 0.3s;
            }
            .select2-container--default.select2-container--focus .select2-selection--single {
                background-color: white;
                border-color: #D4AF37;
                box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
            }
            .select2-dropdown {
                border-radius: 1.5rem;
                border: 1px solid #F1F5F9;
                box-shadow: 0 20px 50px rgba(0,0,0,0.1);
                overflow: hidden;
                padding: 10px;
            }
            .select2-results__option {
                padding: 12px 20px;
                border-radius: 0.75rem;
                font-size: 13px;
                font-weight: 700;
                color: #0F172A;
            }
            .select2-results__option--highlighted[aria-selected] {
                background-color: #D4AF37 !important;
            }
        </style>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'gold-light': '#F4E7B3',
                            'gold': '#D4AF37',
                            'gold-dark': '#B8860B',
                            'gold-premium': '#C5A028',
                            'royal-navy': '#0F172A',
                            'silk-premium': '#F1F5F9',
                            'silk': '#F8FAFC',
                        },
                        fontFamily: {
                            playfair: ['"Playfair Display"', 'serif'],
                            jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="font-jakarta antialiased text-slate-900 bg-silk-premium min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Mobile Header -->
        <header class="lg:hidden bg-white/70 backdrop-blur-xl border-b border-gold/10 sticky top-0 z-50 flex items-center justify-between px-6 h-20 shadow-sm no-print">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-royal-navy flex items-center justify-center p-2 shadow-lg shadow-royal-navy/20">
                    <x-application-logo class="w-full h-full text-gold" />
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-gold-dark uppercase tracking-[0.3em] leading-none">Delphi Portal</span>
                    @if (isset($header))
                        <h1 class="text-xs font-black text-royal-navy uppercase tracking-tight mt-1 font-playfair italic">{{ $header }}</h1>
                    @endif
                </div>
            </div>
            <button @click="sidebarOpen = true" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-silk border border-gold/10 text-gold-dark hover:text-gold transition-all active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        </header>

        <div class="flex min-h-screen">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Page Heading (Desktop) -->
                @if (isset($header))
                    <header class="bg-white/40 backdrop-blur-md border-b border-gold/5 sticky top-0 z-40 hidden lg:block">
                        <div class="max-w-7xl mx-auto py-8 px-8">
                            <div class="animate-fade-in font-playfair">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 lg:p-8 animate-fade-in delay-1 overflow-x-hidden">
                    <div class="max-w-7xl mx-auto px-6 py-6 sm:px-8 lg:px-0">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <x-ai-chatbot />

        <!-- Select2 JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                // Initialize Select2 for all elements with .select2 class
                function initSelect2() {
                    $('.select2').each(function() {
                        $(this).select2({
                            placeholder: $(this).data('placeholder') || "Ketik / Cari data (min 1 huruf)...",
                            allowClear: true,
                            width: '100%',
                            minimumInputLength: 0, // Show all by default
                            language: {
                                noResults: function() {
                                    return "Data tidak ditemukan...";
                                },
                                searching: function() {
                                    return "Mencari...";
                                }
                            }
                        });
                    });
                }

                initSelect2();

                // Re-init for dynamically added elements if any
                $(document).on('select2:open', () => {
                    document.querySelector('.select2-search__field').focus();
                });
            });
        </script>
    </body>
</html>
