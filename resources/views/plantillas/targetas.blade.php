@props([
    'width' => 'w-64',
    'height' => 'h-32',
    'color' => 'bg-blue-500',
    'rounded' => 'rounded-lg',
])

<div class="{{ $width }} {{ $height }} {{ $color }} {{ $rounded }}">
    {{ $slot }}
</div>
