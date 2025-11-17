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

<form method="POST" action="{{ route('tareas.destroy', $tarea->id ?? '') }}"
    class="{{ $width }} {{ $height == 'auto' ? '' : $height }} flex flex-col gap-2 {{ $padding }} {{ $bg }} {{ $borderColor }} {{ $rounded }}">
    @csrf
    @method('DELETE')
    <div class="flex justify-end">
        <x-botones text="Edit" type="button" color="#191919" text_color="#fff" size="sm" height="small"
            border_color="#3A3A3A" margin_right="mr-2"
            onclick="window.location.href='{{ route('tareas.edit', $tarea->id) }}'">
        </x-botones>
        <x-botones text="Delete" type="submit" color="#ff0000" text_color="#fff" size="sm" height="small"
            border_color="#3A3A3A">
        </x-botones>
    </div>
</form>
