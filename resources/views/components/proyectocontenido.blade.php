@props([
    'width' => '',
    'bg' => 'bg-[#111111]',
    'marginRight' => 'mr-[6px]',
    'marginBottom' => 'mb-[6px]',
    'rounded' => 'rounded-[10px]',
    'padding' => 'p-5',
    'border' => 'border border-[#3A3A3A]',
    'flex' => 'flex items-start',
])

{{-- Aqui como solo va atener que ir los proyectos creados simplemente es un div, luego se tiene que mejorar --}}
{{-- ⚠️⚠️ MEJORAR PARA LA CREACION DE PROYECTOS CON EL CONTROLADOR ⚠️⚠️ --}}
<div
    class="{{ $width }} {{ $bg }} {{ $marginRight }} {{ $marginBottom }} {{ $rounded }} {{ $padding }} {{ $border }} {{ $flex }}">
    {{ $slot }}
</div>
