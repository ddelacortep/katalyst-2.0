@php
    $iconosArriba = ['home.svg', 'calendario.svg', 'time_tracker.svg', 'star.svg'];
    $iconoAbajo = 'user_mas.svg';
@endphp

@props([
    'width' => '71px',
    'bg' => '#191919',
    'iconSize' => 'w-35 h-35',
    'topSpace' => '150px',
])

<div class="flex flex-col items-center fixed left-0 justify-between"
    style="width: {{ $width }}; top: {{ $topSpace }}; bottom: 0; background-color: {{ $bg }};">
    <div class="flex flex-col items-center pt-8" style="gap: 40px;">
        @foreach ($iconosArriba as $img)
            <button class="hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/fixedbar_icons/' . $img) }}" alt="{{ $img }}"
                    class="{{ $iconSize }}">
            </button>
        @endforeach
    </div>

    <div class="pb-8">
        <button class="hover:opacity-80 transition-opacity">
            <img src="{{ asset('images/fixedbar_icons/' . $iconoAbajo) }}" alt="{{ $iconoAbajo }}"
                class="{{ $iconSize }}">
        </button>
    </div>
</div>
