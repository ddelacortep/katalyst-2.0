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
    class="flex flex-col border {{ $height }} {{ $width }} {{ $bg }} {{ $rounded }} {{ $padding }} {{ $borderColor }} {{ $marginBottom }}">
    {{-- Contenido de gestion de proyecto --}}
    {{ $slot }}
    {{-- Añade más contenido según sea necesario --}}

    <div id="contenedorProyectos" class="mt-4 space-y-3 overflow-y-auto">
    {{-- Aquí se agregarán los proyectos dinámicamente --}}
    </div>
</div>

