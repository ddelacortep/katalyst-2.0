@extends('layouts.app')

@section('content')
    {{-- Mensajes de éxito y error --}}
    @if(session('success'))
        <div class="fixed top-20 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.bg-green-600').remove();
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.bg-red-600').remove();
            }, 5000);
        </script>
    @endif

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

            <div class="projectbar-desktop bg-transparent ml-[6px] mb-[6px] flex flex-col min-h-0 h-auto"
                style="display:block;">
                <x-gestionproyecto marginBottom="border-b-4" height="h-[calc(100vh-152px)]">
                    <div class="flex-shrink-0 grid grid-cols-2 gap-4 flex items-center">
                        <h2 class="text-2xl font-semibold text-[#fff] flex items-center justify-center">Inicio</h2>
                    </div>
                    <div
                        class="flex-1 mt-6 overflow-y-auto min-h-0 pr-2
                    [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                        <div class="flex flex-col items-center space-y-3">
                            @if (isset($proyectos) && $proyectos->count() > 0)
                                @foreach ($proyectos as $proyecto)
                                    <x-proyectos height="h-[60px]" width="w-[170px]" padding="p-3"
                                        class="proyecto-card @if (isset($proyectoSeleccionado) && $proyectoSeleccionado->id == $proyecto->id) border-blue-500 border-4 @endif cursor-pointer"
                                        data-proyecto-id="{{ $proyecto->id }}"
                                        onclick="cargarTareasProyecto({{ $proyecto->id }})">
                                        <div class="w-full flex items-center justify-center px-2">
                                            <h2 class="text-white font-semibold text-sm truncate max-w-full">
                                                {{ $proyecto->nombre_proyecto }}
                                            </h2>
                                        </div>
                                    </x-proyectos>
                                @endforeach
                            @else
                                <div class="text-gray-500 text-center py-8">
                                    <p>No hay proyectos aún, dirigete a la pestaña de proyectos para crear uno!</p>
                                    <p class="text-sm mt-2">Crea tu primer proyecto</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-gestionproyecto>
            </div>

            {{-- CONTENEDOR KANBAN - Lado derecho --}}
            <div id="kanban-container" class="bg-transparent mr-[6px] mb-[6px] flex flex-col min-h-0 opacity-0 transition-opacity duration-500 ease-in-out">
                <div class="bg-[#191919] rounded-lg p-6 h-full flex flex-col">
                    {{-- Header del Kanban --}}
                    <div id="kanban-header" class="flex-shrink-0 mb-6">
                        <h2 id="proyecto-nombre" class="text-2xl font-semibold text-white">Selecciona un proyecto</h2>
                    </div>

                    {{-- Columnas del Kanban --}}
                    <div id="kanban-board" class="flex-1 grid grid-cols-3 gap-6 min-h-0">
                        {{-- Columna Pendiente --}}
                        <div class="kanban-column bg-[#2d2d44] rounded-lg p-4 flex flex-col" data-estado-id="1">
                            <h3 class="text-lg font-semibold text-white mb-4 text-center border-b border-gray-600 pb-2">
                                Pendiente
                            </h3>
                            <div class="tareas-container flex-1 space-y-3 overflow-y-auto min-h-0
                                [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-700 
                                [&::-webkit-scrollbar-thumb]:bg-gray-500 [&::-webkit-scrollbar-thumb]:rounded-full">
                                {{-- Las tareas se cargarán aquí via AJAX --}}
                            </div>
                        </div>

                        {{-- Columna En Progreso --}}
                        <div class="kanban-column bg-[#2d2d44] rounded-lg p-4 flex flex-col" data-estado-id="2">
                            <h3 class="text-lg font-semibold text-white mb-4 text-center border-b border-yellow-600 pb-2">
                                En Progreso
                            </h3>
                            <div class="tareas-container flex-1 space-y-3 overflow-y-auto min-h-0
                                [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-700 
                                [&::-webkit-scrollbar-thumb]:bg-gray-500 [&::-webkit-scrollbar-thumb]:rounded-full">
                                {{-- Las tareas se cargarán aquí via AJAX --}}
                            </div>
                        </div>

                        {{-- Columna Completado --}}
                        <div class="kanban-column bg-[#2d2d44] rounded-lg p-4 flex flex-col" data-estado-id="3">
                            <h3 class="text-lg font-semibold text-white mb-4 text-center border-b border-green-600 pb-2">
                                Completado
                            </h3>
                            <div class="tareas-container flex-1 space-y-3 overflow-y-auto min-h-0
                                [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-700 
                                [&::-webkit-scrollbar-thumb]:bg-gray-500 [&::-webkit-scrollbar-thumb]:rounded-full">
                                {{-- Las tareas se cargarán aquí via AJAX --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/canvan.js') }}"></script></script>
@endsection
