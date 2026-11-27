@props(['message' => null])

@if (filled($message))
    <p {{ $attributes->merge(['role' => 'alert', 'class' => 'text-xs text-red-600 font-medium mt-1 flex items-start gap-1.5 leading-snug']) }}>
        <svg class="w-3.5 h-3.5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
        </svg>
        <span>{{ $message }}</span>
    </p>
@endif
