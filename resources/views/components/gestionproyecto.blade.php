@props([
    'width' => 'w-full',
    'bg' => 'bg-[#191919]',
    'borderColor' => 'border-[#3A3A3A]',
    'rounded' => 'rounded-[10px]',
    'padding' => 'p-5',
    'height' => 'h-full',
])

<div>
    <div
        class="flex flex-col border {{ $height }} {{ $width }} {{ $bg }} {{ $rounded }} {{ $padding }} {{ $borderColor }}">
        {{-- Contenido de gestion de proyecto --}}
        <h2 class="text-2xl font-semibold mb-4">Gestión de Proyecto</h2>
        {{-- Añade más contenido según sea necesario --}}
    </div>
</div>
