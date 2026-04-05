@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-[10px] text-gray-400 uppercase tracking-[0.2em] mb-2 px-1']) }} style="display: block !important; font-weight: 900 !important; font-size: 10px !important; color: #94a3b8 !important; text-transform: uppercase !important; letter-spacing: 0.2em !important; margin-bottom: 0.5rem !important;">
    {{ $value ?? $slot }}
</label>
