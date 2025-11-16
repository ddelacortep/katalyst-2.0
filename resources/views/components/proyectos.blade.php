@props([
    'id' => 'targetaModal',
    'height' => 'h-[300px]',
    'width' => 'w-[400px]',
    'bg' => 'bg-[#191919]',
    'borderColor' => 'border-[#3A3A3A]',
    'rounded' => 'rounded-[10px]',
    'padding' => 'p-5',
    'onclick' => '',
    'href' => null,
    'hoverEffect' => true,
])

<div 
    @if($onclick) onclick="{{ $onclick }}" @endif
    @if($href) onclick="window.location.href='{{ $href }}'" @endif
    class="{{ $height }} {{ $width }} {{ $bg }} {{ $rounded }} {{ $padding }}border-2 {{ $borderColor }}
        @if($hoverEffect)
            hover:brightness-110 hover:scale-105 hover:border-white
            transition-all duration-300 ease-in-out
            cursor-pointer
        @endif
        flex flex-col items-center justify-center
        shadow-lg
    ">
    {{-- Contenido del slot --}}
    {{ $slot }}
</div>
