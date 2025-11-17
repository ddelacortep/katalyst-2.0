@extends('layouts.app')

@section('content')
    {{-- Contenedor principal con flexbox --}}
    <div class="flex flex-col h-screen">

        {{-- Esto sirve para que la altura sea automatica, que sino se va para abajo --}}
        <div class="flex-shrink-0">
            <x-navbar />
        </div>

        {{-- GRID PRINCIPAL: ocupa el resto del espacio --}}
        <div class="grid gap-1.5 flex-1 min-h-0" style="grid-template-columns: 71px 0.8fr 5fr;">
            <div>
                <x-fixedbar />
            </div>

            {{-- ⚠️⚠️ Esto tiene que ser cambiado por un componente real de gestion de proyectos (DaniDLC) ⚠️⚠️ --}}
            <div class="bg-transparent ml-[6px] mb-[6px] flex flex-col min-h-0 h-auto">
                <x-gestionproyecto marginBottom="border-b-4" height="h-[calc(100vh-152px)]">
                    <div class="flex-shrink-0 grid grid-cols-2 gap-4 flex items-center">
                        <h2 class="text-2xl font-semibold text-[#fff] flex items-center justify-center">Inicio</h2>
                        <div class="flex justify-center">
                            <x-botones onclick="openModal('targetaModal')" text="Crear" type="button" color="#191919"
                                text_color="#fff" size="sm" height="small" border_color="#3A3A3A">
                            </x-botones>
                        </div>
                    </div>
                    <div
                        class="flex-1 mt-6 overflow-y-auto min-h-0 pr-2
                    [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                        <div class="flex flex-col items-center space-y-3">
                            @if (isset($proyectos) && $proyectos->count() > 0)
                                @foreach ($proyectos as $proyecto)
                                    <x-proyectos height="h-[60px]" width="w-[170px]" padding="p-3"
                                        onclick="seleccionarProyecto({{ $proyecto->id }})">

                                        <div class="w-full flex items-center justify-center px-2">
                                            <h2 class="text-white font-semibold text-sm truncate max-w-full">
                                                {{ $proyecto->nombre_proyecto }}
                                            </h2>
                                        </div>
                                    </x-proyectos>
                                @endforeach
                            @else
                                <div class="text-gray-500 text-center py-8">
                                    <p>No hay proyectos aún</p>
                                    <p class="text-sm mt-2">Crea tu primer proyecto</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <x-targeta id="targetaModal" onclick="closeModal('targetaModal')" title="Crear Proyecto"
                            text="hola" height="h-[200px]" width="w-[750px]" padding="p-6">
                            <h2 class='text-white'>Información del proyecto</h2>
                            <br>
                            <form method="POST" action="{{ route('proyecto.store') }}">
                                @csrf
                                <input type="text" name="nombre_proyecto"
                                    class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                    placeholder="Nombre del proyecto">
                                <div class="flex justify-end mt-4">
                                    <x-botones text="Guardar" type="submit" color="#191919" text_color="#fff"
                                        size="sm" height="small" border_color="#3A3A3A" class="mt-4">
                                    </x-botones>
                                </div>
                            </form>
                        </x-targeta>
                    </div>
                </x-gestionproyecto>
            </div>

            {{-- ⚠️⚠️ Aqui tienen que ir todoas las tareas creadas ⚠️⚠️ --}}
            <div class="h-full">
                <x-proyectocontenido flex="flex justify-between" class="h-full">
                    <div class="flex justify-start items-start">
                        <x-botones text="Filtro" type="button" color="#191919" text_color="#fff" size="md"
                            height="small" href="{{ route('prueba') }}" img="images/filter.svg" border_color="#3A3A3A">
                        </x-botones>
                    </div>
                    <div class="flex justify-end items-start">
                        <x-botones onclick="openModal('tareaModal')" text="+ Tarea" type="button" color="#191919"
                            text_color="#fff" size="sm" height="small" border_color="#3A3A3A">
                        </x-botones>
                    </div>
                </x-proyectocontenido>
                
                <div class="grid w-full mt-2 border-2 border-gray-700 rounded-[10px] p-4 mr-2">
                    <x-tarea width="w-full" display="inline-block" justify="justify-center" height="auto" :estados="$estados"/>
                </div>
                    <!-- Grid de tareas debajo del filtro y botón + Tarea -->
                <!-- Modal para crear tarea -->
                <div id="tareaModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-[#232323] rounded-lg p-8 w-[400px] mx-auto flex flex-col">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl text-white font-bold">Crear Tarea</h2>
                            <x-botones text="×" type="button" color="#232323" text_color="#fff" size="md"
                                height="small" border_color="#3A3A3A" onclick="closeModal('tareaModal')" />
                        </div>
                        <form method="POST" action="{{ route('tareas.store') }}">
                            @csrf
                            <input type="text" name="nombre_tarea"
                                class="w-full p-2 rounded bg-[#2C2C2C] text-white border border-[#3A3A3A] mb-4"
                                placeholder="Nombre de la tarea" required>
                            <textarea name="descripcion" class="w-full p-2 rounded bg-[#2C2C2C] text-white border border-[#3A3A3A] mb-4"
                                placeholder="Descripción"></textarea>
                            <input type="date" name="fecha_limite"
                                class="w-full p-2 rounded bg-[#2C2C2C] text-white border border-[#3A3A3A] mb-4"
                                placeholder="Fecha de Límite">
                            <x-prioridad :prioridad="$prioridad" />
                            
                            <div class="flex justify-end">
                                <x-botones text="Guardar" type="submit" color="#191919" text_color="#fff"
                                    size="sm" height="small" border_color="#3A3A3A" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal.js') }}"></script>
@endsection
