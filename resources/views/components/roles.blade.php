@props(['rol' => []])

<select class="bg-[#191919] border border-[#3A3A3A] text-white rounded-lg p-2 w-full">
    <option value="">Rol</option>
    @foreach($rol as $r)
        <option value="{{ $r->id }}" class="text-white" style="color: #fff;">{{ $r->nombre_rol }}</option>
    @endforeach
</select>