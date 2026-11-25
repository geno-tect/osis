@props(['name', 'size' => 20])

<svg {{ $attributes->merge([
    'class' => 'icon',
    'width' => $size,
    'height' => $size,
    'viewBox' => '0 0 24 24',
    'fill' => 'none',
    'stroke' => 'currentColor',
    'stroke-width' => '1.8',
    'stroke-linecap' => 'round',
    'stroke-linejoin' => 'round',
    'aria-hidden' => 'true',
    'focusable' => 'false',
]) }}>
    @switch($name)
        @case('check')
            <path d="m5 12 4 4L19 6" />
            @break

        @case('chevron-down')
            <path d="m6 9 6 6 6-6" />
            @break

        @case('arrow-left')
            <path d="M19 12H5" />
            <path d="m12 19-7-7 7-7" />
            @break

        @case('map-pin')
            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" />
            <circle cx="12" cy="10" r="2.5" />
            @break

        @case('instagram')
            <rect x="3" y="3" width="18" height="18" rx="5" />
            <circle cx="12" cy="12" r="4" />
            <circle cx="17.5" cy="6.5" r=".9" fill="currentColor" stroke="none" />
            @break

        @case('youtube')
            <path d="M21.6 7.2a2.8 2.8 0 0 0-2-2C17.8 4.7 12 4.7 12 4.7s-5.8 0-7.6.5a2.8 2.8 0 0 0-2 2A29 29 0 0 0 2 12a29 29 0 0 0 .4 4.8 2.8 2.8 0 0 0 2 2c1.8.5 7.6.5 7.6.5s5.8 0 7.6-.5a2.8 2.8 0 0 0 2-2A29 29 0 0 0 22 12a29 29 0 0 0-.4-4.8Z" />
            <path fill="currentColor" stroke="none" d="m10 15.5 5-3.5-5-3.5v7Z" />
            @break
    @endswitch
</svg>
