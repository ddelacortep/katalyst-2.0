@props([
    'width' => 'w-[100%]',
    'bg' => 'bg-[#111111]',
    'marginTop' => 'mt-[156px]',
    'marginRight' => 'mr-[6px]',
    'marginBottom' => 'mb-[6px]',
    'rounded' => 'rounded-[10px]',
    'padding' => 'p-5',
    'border' => 'border border-[#3A3A3A]',
    'flex' => 'flex flex-col',
])
<div
    class="{{ $width }} {{ $bg }} {{ $marginTop }} {{ $marginRight }} {{ $marginBottom }} {{ $rounded }} {{ $padding }} {{ $border }} {{ $flex }} {{ $marginRight }}">
    {{ $slot }}
</div>
