@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-silk border-transparent focus:border-gold focus:ring-4 focus:ring-gold/10 rounded-2xl py-4 px-6 text-royal-navy font-bold transition-all placeholder:text-gray-300']) !!} style="background-color: #f1f5f9 !important; border: 1px solid transparent !important; border-radius: 1rem !important; padding: 12px 24px !important; font-weight: 700 !important; width: 100% !important; display: block !important;">
