@props([
    'logo' => 'images/logo.svg', // Guardar la ruta que sino el sistema no se entera de na
    'alturalogo' => 'h-20',
    'fondoinput' => 'Buscar proyecto...',
])

<div class="grid grid-cols-12 gap-6 mt-[30px] mb-[30px] px-[90px]">
    {{-- Logo para que ocupe solo las columnas 1 y 2 --}}
    <div class="col-span-2 flex items-center justify-start">
        <img src="{{ asset($logo) }}" alt="Logo" class="{{ $alturalogo }}">
    </div>

    {{-- Input para que sea lo mas ancho posible (Columnas 3 a 10) --}}
    <div class="col-span-8 flex items-center justify-center w-full">
        <x-input name="search" type="text" placeholder="{{ $fondoinput }}" heigth="h-[50px]" width="w-full"
            padding="p-[10px]" borderRadius="rounded-[10px]" />
    </div>
</div>

{{-- ⚠️⚠️ Imagen de logout DE PRUEBA ⚠️⚠️ (Columnas 11 y 12) --}}
<div class="col-span-2 flex items-center justify-end gap-3">
    <span class="text-white font-medium text-sm">
        {{ Auth::user()->nombre_usuario ?? 'Usuario' }}
    </span>
    <img src="images/logout.svg" alt="Logout">
</div>
