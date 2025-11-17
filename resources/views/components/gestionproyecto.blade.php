@props([
    'width' => 'w-full',
    'bg' => 'bg-[#191919]',
    'borderColor' => 'border-[#111111]',
    'rounded' => 'rounded-[10px]',
    'padding' => 'p-5',
    'height' => 'h-full',
    'marginBottom' => 'border-b',
])


<div
    class="flex flex-col border {{ $height }} {{ $width }} {{ $bg }} {{ $rounded }} {{ $padding }} {{ $borderColor }} {{ $marginBottom }} min-h-0 max-h-full overflow-hidden">
    {{-- Contenido de gestion de proyecto --}}
    {{ $slot }}
</div>

