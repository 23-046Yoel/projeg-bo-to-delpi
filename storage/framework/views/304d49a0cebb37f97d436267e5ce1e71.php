<div <?php echo e($attributes->merge(['class' => 'flex flex-col items-center justify-center'])); ?>>
    <div class="relative group">
        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 drop-shadow-2xl transition-transform duration-700 group-hover:rotate-12">
            <!-- Luxury Outer Glow/Frame -->
            <path d="M50 2L96 25V75L50 98L4 75V25L50 2Z" class="fill-royal-navy" />
            <path d="M50 8L88 27V73L50 92L12 27V73L50 92Z" stroke="#D4AF37" stroke-width="0.5" stroke-dasharray="2 2" opacity="0.4"/>
            
            <!-- Modern 'D' Monogram for Delphi -->
            <path d="M38 30V70C55 70 68 62 68 50C68 38 55 30 38 30Z" stroke="url(#gold_grad)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M38 42H55" stroke="#D4AF37" stroke-width="1.5" stroke-linecap="round" opacity="0.3"/>
            <path d="M38 58H50" stroke="#D4AF37" stroke-width="1.5" stroke-linecap="round" opacity="0.3"/>
            
            <!-- Decorative Center Dot -->
            <circle cx="50" cy="50" r="1.5" fill="#D4AF37" class="animate-pulse"/>
            
            <defs>
                <linearGradient id="gold_grad" x1="38" y1="30" x2="68" y2="70" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#D4AF37"/>
                    <stop offset="0.5" stop-color="#F9F1D0"/>
                    <stop offset="1" stop-color="#B8860B"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <div class="mt-4 text-center">
        <h1 class="text-xl font-black text-royal-navy tracking-[0.2em] uppercase leading-none">BoTo</h1>
        <p class="text-[8px] font-black text-gold-dark tracking-[0.4em] uppercase mt-1">Delphi Edition</p>
    </div>
</div>
    <?php /**PATH C:\laragon\www\projeg Bo To Delpi\resources\views/components/application-logo.blade.php ENDPATH**/ ?>