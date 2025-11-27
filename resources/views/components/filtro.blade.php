@props([
    'options' => [
        'fecha' => 'Fecha',
        'prioridad' => 'Prioridad',
        'estado' => 'Estado',
    ],
    'name' => 'filtro',
    'selected' => '',
])

<div class="relative inline-block w-48">
    <select name="{{ $name }}" class="block w-full p-2 bg-[#191919] text-white border border-[#3A3A3A] rounded-lg">
        <option value="" class="w-[40px]">Filtros</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" @if($selected == $value) selected @endif>{{ $label }}</option>
        @endforeach
    </select>
</div>