@extends('layouts.app')

@section('content')
    {{-- Contenedor principal con flexbox --}}
    <div class="flex flex-col h-screen">

        {{-- Esto sirve para que la altura sea automatica, que sino se va para abajo --}}
        <div class="flex-shrink-0">
            <x-navbar />
        </div>

        {{-- GRID PRINCIPAL: ocupa el resto del espacio --}}
        <div class="grid gap-1.5 flex-1" style="grid-template-columns: 71px 0.8fr 5fr;">
            <div>
                <x-fixedbar />
            </div>

            {{-- ⚠️⚠️ Esto tiene que ser cambiado por un componente real de gestion de proyectos (DaniDLC) ⚠️⚠️ --}}
            <div class="bg-transparent mb-[6px] ml-[6px] overflow-y-auto">
                <div class="h-full border border-dashed border-gray-500 rounded-lg p-4">
                    <p class="text-gray-500">Gestión de Proyectos</p>
                </div>
            </div>

            {{-- ⚠️⚠️ Aqui tienen que ir todos los proyectos creados ⚠️⚠️ --}}
            <div class="h-full">
                <x-proyectocontenido flex="flex justify-between" class="h-full">
                    <div class="flex justify-start items-start">
                        <x-botones text="Filtro" type="button" color="#191919" text_color="#fff" size="md"
                            height="small" href="{{ route('prueba') }}" img="images/filter.svg" border_color="#3A3A3A">
                        </x-botones>
                    </div>
                    <div class="flex justify-end items-start">
                        <x-botones text="+ Tarea" type="button" color="#191919" text_color="#fff" size="md"
                            height="small" href="{{ route('prueba') }}" border_color="#3A3A3A">
                        </x-botones>
                    </div>
                </x-proyectocontenido>
                <div>
                    <x-targeta id="targetaModal" onclick="closeModal('targetaModal')" title="Crear Proyecto" text="hola" height="h-[150px]" width="w-[500px]" padding="p-6">
                        <h2 class='text-white'>Información del proyecto</h2>
                        <br>
                        <form>
                            <input type="text" name="nombre" class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]" placeholder="Nombre del proyecto">
                        </form>
                    </x-targeta>    

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal.js') }}"></script>
@endsection


