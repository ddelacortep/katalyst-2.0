@props(['prioridad' => []])

<select class="bg-[#191919] border border-[#3A3A3A] text-white rounded-lg p-2 w-full">
    <option value="">Prioridad</option>
    @foreach($prioridad as $p)
        <option value="{{ $p->id }}" class="text-white" style="color: #fff;">{{ $p->nombre_prioridad }}</option>
    @endforeach
</select>
