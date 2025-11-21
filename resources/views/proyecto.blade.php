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
                                        class="@if (isset($proyectoSeleccionado) && $proyectoSeleccionado->id == $proyecto->id) border-blue-500 border-4 @endif"
                                        onclick="window.location.href='{{ route('proyecto.show', $proyecto->id) }}'">

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
                    <div class="flex justify-end items-start gap-2">
                        @if (isset($proyectoSeleccionado) && $proyectoSeleccionado)
                            <x-botones 
                                type="button" 
                                color="#191919" 
                                text_color="#fff" 
                                size="sm" 
                                height="small"
                                img="images/fixedbar_icons/user_mas.svg"
                                border_color="#3A3A3A"
                                onclick="openModal('invitarModal')">
                            </x-botones>

                            <x-botones
                                onclick="openModal('tareaModal')"
                                text="+ Tarea" type="button" color="#191919" text_color="#fff" size="sm" height="small"
                                border_color="#3A3A3A" marginRight="mr-5">
                            </x-botones>
                            <form method="POST" action="{{ route('proyecto.destroy', $proyectoSeleccionado->id) }}" onsubmit="return confirm('¿Seguro que quieres eliminar este proyecto?');">
                                @csrf
                                @method('DELETE')
                                <x-botones text="Eliminar Proyecto" type="submit" color="#ff0000" text_color="#fff" size="sm" height="small" border_color="#3A3A3A" />
                            </form>
                        @else
                            <x-botones
                                onclick="alert('Selecciona un proyecto primero')"
                                text="+ Tarea" type="button" color="#191919" text_color="#fff" size="sm" height="small"
                                border_color="#3A3A3A">
                            </x-botones>
                        @endif
                    </div>
                </x-proyectocontenido>


                <div class="w-full mt-2 border-2 border-gray-700 rounded-[10px] p-4 mr-2 overflow-y-auto max-h-[74vh]">
                    @if (isset($tareas) && $tareas->count() > 0)
                        @foreach ($tareas->chunk(2) as $tareaFila)
                            <div class="flex flex-row gap-4 mb-4">
                                @foreach ($tareaFila as $tarea)
                                    <div class="bg-gray-800 rounded-lg p-4 flex-1">
                                        <h3 class="text-lg font-bold text-white">{{ $tarea->nombre_tarea }}</h3>
                                        <p class="text-gray-300 mb-1">{{ $tarea->desc_tarea }}</p>
                                        <p class="text-gray-400 text-sm">Fecha creación: {{ $tarea->fecha_creacion }}</p>
                                        <p class="text-gray-400 text-sm">Fecha límite: {{ $tarea->fecha_limite }}</p>
                                        <p class="text-gray-400 text-sm">Prioridad: {{ $tarea->prioridad->nombre_prioridad ?? '' }}</p>
                                        <p class="text-gray-400 text-sm">Estado: {{ $tarea->estado?->nombre_estado ?? '' }}</p>
                                        <p class="text-gray-400 text-sm">Usuario: {{ $tarea->nombre_usuario }}</p>
                                        <x-tarea width="w-full" display="inline-block" justify="justify-center" height="auto"
                                            :estados="$estados" :tarea="$tarea" bg="transparent" />
                                    </div>
                                @endforeach
                                @if(session('status'))
                                    <div id="toast-status" class="fixed bottom-4 right-4 z-50 opacity-0 transition-opacity duration-500 ease-in-out pointer-events-none">
                                        <x-botones
                                            text="{{ session('status') }}"
                                            type="button"
                                            color="#191919"
                                            text_color="#fff"
                                            size="sm"
                                            height="small"
                                            border_color="#3A3A3A"
                                        />
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const toast = document.getElementById('toast-status');
                                            if (toast) {
                                                requestAnimationFrame(() => {
                                                    toast.classList.remove('opacity-0');
                                                    toast.classList.add('opacity-100');
                                                });
                                                setTimeout(() => {
                                                    toast.classList.remove('opacity-100');
                                                    toast.classList.add('opacity-0');
                                                    setTimeout(() => { toast.remove(); }, 500);
                                                }, 5000);
                                            }
                                        });
                                    </script>
                                @endif

                            </div>
                        @endforeach
                    @elseif(isset($proyectoSeleccionado))
                        <div class="text-gray-500 text-center py-8">
                            <p>No hay tareas en este proyecto</p>
                            <p class="text-sm mt-2">Crea tu primera tarea</p>
                        </div>
                    @else
                        <div class="text-gray-500 text-center py-8">
                            <p>Selecciona un proyecto para ver sus tareas</p>
                        </div>
                    @endif
                </div>
                
                <!-- x-targeta para crear tarea -->
                <x-targeta id="tareaModal"  title="Crear Tarea"
                    text="Nueva tarea" height="h-auto" width="w-[750px]" padding="p-6">
                    <h2 class='text-white mb-4'>Información de la tarea</h2>
                    <form method="POST" action="{{ route('tareas.store') }}">
                        @csrf
                        @if(isset($proyectoSeleccionado) && $proyectoSeleccionado)
                            <input type="hidden" name="id_proyecto" value="{{ $proyectoSeleccionado->id }}">
                        @endif
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Nombre de la tarea</label>
                            <input type="text" name="nombre_tarea"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                placeholder="Nombre de la tarea" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Descripción</label>
                            <textarea name="descripcion" rows="4"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                placeholder="Descripción de la tarea"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Fecha límite</label>
                            <input type="date" name="fecha_limite"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 year')) }}">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Prioridad</label>
                            <x-prioridad :prioridad="$prioridad" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Estados</label>
                            <x-estados :estados="$estados" />
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-botones text="Guardar" type="submit" color="#191919" text_color="#fff"
                                size="sm" height="small" border_color="#3A3A3A">
                            </x-botones>
                        </div>
                    </form>
                </x-targeta>

                <!-- x-targeta para EDITAR tarea -->
                <x-targeta id="editarTareaModal" title="Editar Tarea"
                    text="Modificar tarea" height="h-auto" width="w-[750px]" padding="p-6">
                    <h2 class='text-white mb-4'>Editar información de la tarea</h2>
                    <form method="POST" action="" id="editarTareaForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Nombre de la tarea</label>
                            <input type="text" name="nombre_tarea" id="edit_nombre_tarea"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                placeholder="Nombre de la tarea" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Descripción</label>
                            <textarea name="descripcion" id="edit_descripcion" rows="4"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                placeholder="Descripción de la tarea"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Fecha límite</label>
                            <input type="date" name="fecha_limite" id="edit_fecha_limite"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Prioridad</label>
                            <select name="id_prioridad" id="edit_id_prioridad"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]">
                                @foreach($prioridad as $prior)
                                    <option value="{{ $prior->id }}">{{ $prior->nombre_prioridad }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Estados</label>
                            <select name="id_estado" id="edit_estados"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]">
                                @foreach($estados as $e)
                                    <option value="{{ $e->id }}">{{ $e->nombre_estado }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-botones text="Actualizar" type="submit" color="#191919" text_color="#fff"
                                size="sm" height="small" border_color="#3A3A3A">
                            </x-botones>
                        </div>
                    </form>
                </x-targeta>

                <!-- x-targeta para INVITAR usuarios -->
                @if(isset($proyectoSeleccionado) && $proyectoSeleccionado)
                    <x-targeta id="invitarModal" title="Invitar Colaboradores"
                        text="Invitar usuarios" height="h-auto" width="w-[750px]" padding="p-6">
                        <h2 class='text-white mb-4'>Agregar colaborador al proyecto</h2>
                        <form method="POST" action="{{ route('proyecto.invitar.store', $proyectoSeleccionado->id) }}" id="invitarForm">
                            @csrf
                            <input type="hidden" name="id_proyecto" value="{{ $proyectoSeleccionado->id }}">
                            
                            <div class="mb-4">
                                <label class="block text-gray-400 text-sm mb-2">Usuario</label>
                                <x-colaboradores :usuario="$usuario" />
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-400 text-sm mb-2">Rol</label>
                                <x-roles :rol="$rol" />
                            </div>

                            <div class="mb-6">
                                <h3 class="text-white font-semibold mb-3">Colaboradores actuales:</h3>
                                <div class="max-h-[200px] overflow-y-auto space-y-2">
                                    <div class="flex justify-between items-center bg-[#1a1a1a] p-3 rounded-lg border border-[#3A3A3A]">
                                        <div>
                                            <span class="text-white"></span>
                                            <span class="text-gray-400 text-sm ml-2">(Colaborador)</span>
                                        </div>
                                        <button type="button" class="text-red-500 hover:text-red-700 text-sm">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-6">
                                <x-botones text="Invitar" type="submit" color="#191919" text_color="#fff"
                                    size="sm" height="small" border_color="#3A3A3A">
                                </x-botones>
                            </div>
                        </form>
                    </x-targeta>
                @endif
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modal.js') }}"></script>
@endsection
