@props([
    'id' => 'targetaModal',
    'width' => 'w-full',
    'bg' => 'bg-[#191919]',
    'borderColor' => 'border-t-[#3A3A3A]',
    'rounded' => 'rounded-b-[10px] rounded-t-none',
    'padding' => 'p-5',
    'showClose' => 'true',
    'onclick' => '',
])

<div id="{{ $id }}"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div
    class="flex items-center justify-end gap-3 border-t {{ $borderColor }} pt-4 {{ $width }} {{ $bg }} {{ $rounded }} {{ $padding }}">
    {{-- Contenedor para los botones u otros elementos --}}
    {{ $slot }}
    </div>
</div>