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
])

<div class="{{ $width }} {{ $height == 'auto' ? '' : $height }} flex flex-col gap-2 {{ $padding }} {{ $bg }} {{ $borderColor }} {{ $rounded }}">

    <div class="flex justify-end">
        <x-botones text="Delete" type="button" color="#191919" text_color="#fff" size="sm"
            height="small" border_color="#3A3A3A">
        </x-botones>
    </div>
</div>