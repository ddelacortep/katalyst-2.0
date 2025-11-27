@props(['usuario' => []])

<select class="bg-[#191919] border border-[#3A3A3A] text-white rounded-lg p-2 w-full">
    <option value="">Usuario</option>
    @foreach($usuario as $u)
        <option value="{{ $u->id }}" class="text-white" style="color: #fff;">{{ $u->nombre_usuario }}</option>
    @endforeach
</select>