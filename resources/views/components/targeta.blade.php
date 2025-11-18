@props([
    'id' => 'targetaModal',
    'height' => 'h-[300px]',
    'width' => 'w-[400px]',
    'bg' => 'bg-[#191919]',
    'borderColor' => 'border-t-[#fff]',
    'rounded' => 'rounded-[10px]',
    'padding' => 'p-5',
    'showClose' => 'true',
    'onclick' => '',
    'aspectRatio' => '',
    'borderRadius' => 'rounded-[10px]',
])

<div id="{{ $id }}" onclick="closeModal('{{ $id }}')" 
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    
    <div onclick="event.stopPropagation()"
        class="relative {{ $width }} {{ $height }} {{ $bg }} {{ $rounded }} {{ $padding }} border-2 {{ $borderColor }} {{ $aspectRatio }}">
        
        {{-- Botón de cerrar --}}
        @if ($showClose === 'true')
            <button onclick="closeModal('{{ $id }}')"
                class="absolute top-2 right-2 text-white text-xl font-bold hover:text-gray-400">
                &times;
            </button>
        @endif

        {{-- Contenido del modal --}}
        {{ $slot }}
    </div>
</div>
