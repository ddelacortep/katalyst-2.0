@php
    $iconosArriba = [
        ['icono' => 'home.svg', 'ruta' => 'prueba'],
        ['icono' => 'calendario.svg', 'ruta' => 'prueba'],
        ['icono' => 'time_tracker.svg', 'ruta' => 'prueba'],
        ['icono' => 'star.svg', 'ruta' => 'prueba'],
    ];
    $iconoAbajo = ['icono' => 'user_mas.svg', 'ruta' => 'prueba'];
@endphp

@props([
    'width' => 'w-[71px]',
    'bg' => 'bg-[#191919]',
    'iconSize' => 'w-35 h-35',
    'topSpace' => 'top-[150px]',
    'margin' => 'm-3',
    'rounded' => 'r-10',
    'padding' => 'p-5',
])

<div
    class="flex flex-col items-center fixed left-0 bottom-0 justify-between {{ $width }} {{ $topSpace }} {{ $bg }} {{ $margin }} {{ $rounded }} {{ $padding }}">
    <div class="flex flex-col items-center pt-8" style="gap: 40px;">
        @foreach ($iconosArriba as $item)
            <a href="{{ route($item['ruta']) }}"
                class="hover:opacity-80 hover:scale-110 transition-all duration-200 ease-in-out">
                <img src="{{ asset('images/fixedbar_icons/' . $item['icono']) }}" alt="{{ $item['icono'] }}"
                    class="{{ $iconSize }}">
            </a>
        @endforeach
    </div>

    <div class="pb-8">
        <a href="{{ route($iconoAbajo['ruta']) }}"
            class="hover:opacity-80 hover:scale-105 transition-all duration-200 ease-in-out">
            <img src="{{ asset('images/fixedbar_icons/' . $iconoAbajo['icono']) }}" alt="{{ $iconoAbajo['icono'] }}"
                class="{{ $iconSize }}">
        </a>
    </div>
</div>
