@props([
    'id' => 'targetaModal',
    'size' => '500px',
    'bg' => 'bg-[#191919]',
    'borderColor' => 'border-t-[#3A3A3A]',
    'rounded' => 'rounded-b-[10px] rounded-t-none',
    'padding' => 'p-5',
    'showClose' => 'true',
    'onclick' => '',
    'aspectRatio' => '',
])

<div id="{{ $id }}" onclick="closeModal('{{ $id }}')" 
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    
    <div onclick="event.stopPropagation()"
        class="relative w-[{{ $size }}] h-[{{ $size }}] {{ $bg }} {{ $rounded }} {{ $padding }} border-2 {{ $borderColor }} {{ $aspectRatio }}">
        
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
