<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Scripts & AlpineJS (Loaded in head to avoid x-cloak lock on mobile) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <!-- Tailwind CDN Fallback -->
        <script src="https://cdn.tailwindcss.com"></script>
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
        <header class="lg:hidden bg-white/70 backdrop-blur-xl border-b border-gold/10 sticky top-0 z-50 flex items-center justify-between px-6 h-20 shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-royal-navy flex items-center justify-center p-2 shadow-lg shadow-royal-navy/20">
                    <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-full h-full text-gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full h-full text-gold']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-gold-dark uppercase tracking-[0.3em] leading-none">Delphi Portal</span>
                    <?php if(isset($header)): ?>
                        <h1 class="text-xs font-black text-royal-navy uppercase tracking-tight mt-1 font-playfair italic"><?php echo e($header); ?></h1>
                    <?php endif; ?>
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
            <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Page Heading (Desktop) -->
                <?php if(isset($header)): ?>
                    <header class="bg-white/40 backdrop-blur-md border-b border-gold/5 sticky top-0 z-40 hidden lg:block">
                        <div class="max-w-7xl mx-auto py-8 px-8">
                            <div class="animate-fade-in font-playfair">
                                <?php echo e($header); ?>

                            </div>
                        </div>
                    </header>
                <?php endif; ?>

                <!-- Page Content -->
                <main class="flex-1 lg:p-8 animate-fade-in delay-1 overflow-x-hidden" x-cloak>
                    <div class="max-w-7xl mx-auto px-6 py-6 sm:px-8 lg:px-0">
                        <?php echo e($slot); ?>

                    </div>
                </main>
            </div>
        </div>

        <?php if (isset($component)) { $__componentOriginalb1d321e9b0adb2788de206a16234e064 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb1d321e9b0adb2788de206a16234e064 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ai-chatbot','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ai-chatbot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb1d321e9b0adb2788de206a16234e064)): ?>
<?php $attributes = $__attributesOriginalb1d321e9b0adb2788de206a16234e064; ?>
<?php unset($__attributesOriginalb1d321e9b0adb2788de206a16234e064); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb1d321e9b0adb2788de206a16234e064)): ?>
<?php $component = $__componentOriginalb1d321e9b0adb2788de206a16234e064; ?>
<?php unset($__componentOriginalb1d321e9b0adb2788de206a16234e064); ?>
<?php endif; ?>
    </body>
</html>
<?php /**PATH C:\laragon\www\projeg Bo To Delpi\resources\views/layouts/app.blade.php ENDPATH**/ ?>