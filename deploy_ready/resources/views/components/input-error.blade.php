@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }} style="list-style: none !important; padding: 0 !important; margin: 0.5rem 0 0 0 !important; font-size: 11px !important; color: #dc2626 !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.05em !important;">
        @foreach ((array) $messages as $message)
            <li style="margin-bottom: 0.25rem !important;">{{ $message }}</li>
        @endforeach
    </ul>
@endif
