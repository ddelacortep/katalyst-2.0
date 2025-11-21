@props([
    'width' => 'w-full', // Tailwind width class
    'height' => 'auto', // Tailwind height class or 'auto'
    'display' => 'inline-block', // 'inline-block' or 'block' or 'flex'
    'justify' => 'justify-center', // Tailwind justify class
    'padding' => 'p-5',
    'bg' => 'bg-[#111111]',
    'borderColor' => 'border-[#3A3A3A]',
    'rounded' => 'rounded-[10px]',
    'flex' => '',
    'estados' => [],
    'tarea' => null,
])

<div class="{{ $width }} {{ $height == 'auto' ? '' : $height }} flex flex-col gap-2 {{ $padding }} {{ $bg }} {{ $borderColor }} {{ $rounded }}">
    <div class="flex justify-end gap-[10px]">
        <x-botones text="Editar" type="button" color="#191919" text_color="#fff" size="sm" height="small" border_color="#3A3A3A" margin_right="mr-5"
            onclick="openEditarTareaModal({{ $tarea->id }}, '{{ $tarea->nombre_tarea ?? '' }}', '{{ $tarea->desc_tarea ?? '' }}', '{{ $tarea->fecha_limite ?? '' }}', {{ $tarea->id_prioridad ?? 1 }})">
        </x-botones>

        @if(!($tarea->google_event_id))
            <form method="POST" action="{{ route('tasks.push-to-calendar', $tarea) }}">
                @csrf
                <x-botones text="Guardar en Google Calendar" type="submit" color="#191919" text_color="#fff" size="sm" height="small" border_color="#3A3A3A">
                </x-botones>
            </form>
        @else
            <x-botones text="Ver en Google Calendar" href="{{ $tarea->calendar_url }}" target="_blank" color="#191919" text_color="#fff" size="sm" height="small" border_color="#3A3A3A">
            </x-botones>
        @endif

        <form method="POST" action="{{ route('tareas.destroy', $tarea->id ?? '') }}">
            @csrf
            @method('DELETE')
            <x-botones text="Eliminar tarea" type="submit" color="#ff0000" text_color="#fff" size="sm" height="small" border_color="#3A3A3A">
            </x-botones>
        </form>
    </div>
</div>
