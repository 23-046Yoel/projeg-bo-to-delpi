@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }} style="font-weight: 600 !important; font-size: 14px !important; color: #16a34a !important; margin-bottom: 1rem !important; text-align: center !important;">
        {{ $status }}
    </div>
@endif
