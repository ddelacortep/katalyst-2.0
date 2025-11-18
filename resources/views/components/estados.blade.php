@props(['estados' => []])

<select class="bg-[#191919] border border-[#3A3A3A] text-white rounded-lg p-2 w-full">
    <option value="">Estados</option>
    @foreach($estados as $e)
        <option value="{{ $e->id }}" class="text-white" style="color: #fff;">{{ $e->nombre_estado }}</option>
    @endforeach
</select>
