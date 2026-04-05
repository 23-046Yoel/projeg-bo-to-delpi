<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-8 py-3 bg-white border-2 border-royal-navy/10 rounded-2xl font-black text-xs text-royal-navy uppercase tracking-[0.2em] shadow-sm hover:bg-silk hover:border-royal-navy/30 focus:ring-4 focus:ring-gold/10 disabled:opacity-25 transition-all duration-300 transform hover:scale-[1.02]']) }}>
    {{ $slot }}
</button>
