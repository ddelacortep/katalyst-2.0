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
            <div class="bg-transparent ml-[6px] mb-[6px] h-full">
                <x-gestionproyecto marginBottom="border-b-4">
                    <div class="grid grid-cols-2 gap-4 flex items-center">
                        <h2 class="text-2xl font-semibold text-[#fff] flex items-center justify-center">Inicio</h2>
                        <div class="flex justify-center">


                            <x-botones onclick="openModal('targetaModal')" text="Crear" type="button" color="#191919"
                                text_color="#fff" size="sm" height="small" border_color="#3A3A3A">
                            </x-botones>


                        </div>
                    </div>
                    <div>
                        @
                    </div>
                </x-gestionproyecto>
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
                        <x-botones onclick="openModal('targetaTarea')" text="+ Tarea" type="button" color="#191919"
                            text_color="#fff" size="md" height="small" border_color="#3A3A3A">
                        </x-botones>
                    </div>

                </x-proyectocontenido>
                <div>
                    <x-targeta id="targetaModal" onclick="closeModal('targetaModal')" title="Crear Proyecto" text="hola"
                        height="h-[200px]" width="w-[750px]" padding="p-6">
                        <h2 class='text-white'>Información del proyecto</h2>
                        <br>
                        <form method="POST" action="{{ route('proyecto.store') }}">
                            @csrf
                            <input type="text" name="nombre_proyecto"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                placeholder="Nombre del proyecto">
                        </form>
                        <div class="flex justify-end mt-4">
                            <x-botones text="Guardar" type="submit" color="#191919" text_color="#fff" size="sm"
                                height="small" href="{{ route('prueba') }}" border_color="#3A3A3A" class="mt-4">
                            </x-botones>
                        </div>
                    </x-targeta>
                    <x-targeta id="targetaTarea" onclick="closeModal('targetaModal')" title="Crear Proyecto" text="hola"
                        height="h-[200px]" width="w-[750px]" padding="p-6">
                        <h2 class='text-white'>Información de la Tarea</h2>
                        <br>
                        <form method="POST" action="{{ route('tareas.create') }}">
                            @csrf
                            <input type="text" name="nombre_proyecto"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                placeholder="Nombre del proyecto">
                            <input type="text" name="nombre_proyecto"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                placeholder="Nombre del proyecto">
                        </form>
                        <div class="flex justify-end mt-4">
                            <x-botones text="Guardar" type="submit" color="#191919" text_color="#fff" size="sm"
                                height="small" href="{{ route('prueba') }}" border_color="#3A3A3A" class="mt-4">
                            </x-botones>
                        </div>
                    </x-targeta>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal.js') }}"></script>
@endsection
