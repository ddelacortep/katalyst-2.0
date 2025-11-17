@props(['estados' => []])

<select class="bg-[#191919] border border-[#3A3A3A] text-white rounded-lg p-2 w-full">
    <option value="">Selecciona un estado</option>
    @foreach($estados as $estado)
        <option value="{{ $estado->id }}">
            {{ $estado->nombre }}
        </option>
    @endforeach
</select>
