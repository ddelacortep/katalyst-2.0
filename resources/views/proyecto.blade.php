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

            {{-- ⚠️⚠️ Esto tiene que ser cambiado por un componente real de gestion de proyectos (DaniDLC) ⚠️⚠️ --}}
            <style>
                @media (max-width: 700px) {
                    .projectbar-hide-700 {
                        display: none !important;
                    }

                    .hamburger-btn {
                        display: block !important;
                    }
                }

                @media (min-width: 700px) {
                    .hamburger-btn {
                        display: none !important;
                    }
                }
            </style>
            <button class="hamburger-btn fixed top-4 left-4 z-50 bg-[#191919] p-2 rounded-md"
                onclick="document.querySelector('.projectbar-list-mobile').style.display = (document.querySelector('.projectbar-list-mobile').style.display === 'block' ? 'none' : 'block')">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>
            <div class="projectbar-list-mobile"
                style="display:none; position:fixed; top:0; left:0; z-index:40; width:70vw; height:100vh; max-width:300px; box-shadow:2px 0 8px #000; background:#191919;">
                <div class="flex flex-col items-center space-y-3 mt-8">
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

            <div class="projectbar-desktop bg-transparent ml-[6px] mb-[6px] flex flex-col min-h-0 h-auto"
                style="display:block;">
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
                        @if (isset($proyectoSeleccionado) && $proyectoSeleccionado)
                            <form method="GET" action="{{ route('proyecto.show', $proyectoSeleccionado->id) }}" class="flex flex-row items-center gap-2">
                                <x-filtro :options="['fecha' => 'Fecha', 'prioridad' => 'Prioridad', 'estado' => 'Estado']" name="filtro" :selected="request('filtro')" />
                                <x-botones text="Filtrar" type="submit" color="#191919" text_color="#fff" size="sm" height="small" border_color="#3A3A3A" />
                            </form>
                        @endif
                    </div>
                    <div class="flex justify-end items-start gap-2">
                        @if (isset($proyectoSeleccionado) && $proyectoSeleccionado)
                            @if(auth()->user()->canManageIn($proyectoSeleccionado->id))
                                <x-botones onclick="openModal('invitarModal')" img="images/fixedbar_icons/user_mas.svg" type="button" color="#191919"
                                    text_color="#fff" size="sm" height="small" border_color="#3A3A3A"
                                    marginRight="mr-5">
                                </x-botones>
                            @endif
                            <x-botones onclick="openModal('tareaModal')" text="+ Tarea" type="button" color="#191919"
                                text_color="#fff" size="sm" height="small" border_color="#3A3A3A"
                                marginRight="mr-5">
                            </x-botones>
                            @if(auth()->user()->isOwnerOf($proyectoSeleccionado->id))
                                <form method="POST" action="{{ route('proyecto.destroy', $proyectoSeleccionado->id) }}"
                                    onsubmit="return confirm('¿Seguro que quieres eliminar este proyecto?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-botones text="Eliminar Proyecto" type="submit" color="#ff0000" text_color="#fff"
                                        size="sm" height="small" border_color="#3A3A3A" />
                                </form>
                            @endif
                        @else
                            <x-botones onclick="alert('Selecciona un proyecto primero')" text="+ Tarea" type="button"
                                color="#191919" text_color="#fff" size="sm" height="small" border_color="#3A3A3A">
                            </x-botones>
                        @endif
                    </div>
                </x-proyectocontenido>


                <div class="w-full mt-2 border-2 border-gray-700 rounded-[10px] p-4 mr-2 overflow-y-auto max-h-[74vh]">
                    @if (isset($tareas) && $tareas->count() > 0)
                        @foreach ($tareas->chunk(3) as $tareaFila)
                            <div class="flex flex-row gap-4 mb-4">
                                @foreach ($tareaFila as $tarea)
                                    <div class="bg-gray-800 rounded-lg p-4 flex-1">
                                        <h3 class="text-lg font-bold text-white">{{ $tarea->nombre_tarea }}</h3>
                                        <p class="text-gray-300 mb-1">{{ $tarea->desc_tarea }}</p>
                                        <p class="text-gray-400 text-sm">Fecha creación: {{ $tarea->fecha_creacion }}</p>
                                        <p class="text-gray-400 text-sm">Fecha límite: {{ $tarea->fecha_limite }}</p>
                                        <p class="text-gray-400 text-sm">Prioridad:
                                            {{ $tarea->prioridad->nombre_prioridad ?? '' }}</p>
                                        <p class="text-gray-400 text-sm">Estado:
                                            {{ $tarea->estado?->nombre_estado ?? '' }}</p>
                                        <p class="text-gray-400 text-sm">Usuario: {{ $tarea->nombre_usuario }}</p>
                                        <x-tarea width="w-full" display="inline-block" justify="justify-center"
                                            height="auto" :estados="$estados" :tarea="$tarea" bg="transparent" />
                                    </div>
                                @endforeach
                                @if(session('status'))
                                    <div id="toast-status" class="fixed bottom-4 right-4 z-50 opacity-0 transition-opacity duration-500 ease-in-out pointer-events-none">
                                        <div class="bg-[#191919] text-white p-4 rounded-lg shadow-lg border border-[#3A3A3A]">
                                            <p>{{ session('status') }}</p>
                                            @if(session('googleCalendarLink'))
                                                <a href="{{ session('googleCalendarLink') }}" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 underline mt-2 inline-block">
                                                    Sí, añadir
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const toast = document.getElementById('toast-status');
                                            if (toast) {
                                                // Hacemos que el toast sea interactivo
                                                toast.classList.remove('pointer-events-none');

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
                <x-targeta id="tareaModal" title="Crear Tarea" text="Nueva tarea" height="h-auto" width="w-[750px]"
                    padding="p-6">
                    <h2 class='text-white mb-4'>Información de la tarea</h2>
                    <form method="POST" action="{{ route('tareas.store') }}">
                        @csrf
                        @if (isset($proyectoSeleccionado) && $proyectoSeleccionado)
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
                            <x-botones text="Guardar" type="submit" color="#191919" text_color="#fff" size="sm"
                                height="small" border_color="#3A3A3A">
                            </x-botones>
                        </div>
                    </form>
                </x-targeta>

                <!-- x-targeta para EDITAR tarea -->
                <x-targeta id="editarTareaModal" title="Editar Tarea" text="Modificar tarea" height="h-auto"
                    width="w-[750px]" padding="p-6">
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
                                @foreach ($prioridad as $prior)
                                    <option value="{{ $prior->id }}">{{ $prior->nombre_prioridad }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2">Estados</label>
                            <select name="id_estado" id="edit_estados"
                                class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]">
                                @foreach ($estados as $e)
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
                    <x-targeta id="invitarModal" title="Invitar Colaborador" text="Invitar" height="h-auto" width="w-[750px]" padding="p-6">
                        <h2 class='text-white mb-4'>Información del colaborador</h2>
                        <form method="POST" action="{{ route('participa.store') }}">
                            @csrf
                            <input type="hidden" name="id_proyecto" value="{{ $proyectoSeleccionado->id }}">
                            
                            <div class="mb-4">
                                <label class="block text-gray-400 text-sm mb-2">Buscar usuario</label>
                                <input list="usuarios" name="id_usuario" 
                                    class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]"
                                    placeholder="Escribe el nombre del usuario" required>
                                <datalist id="usuarios">
                                    @foreach($usuario as $u)
                                        <option value="{{ $u->nombre_usuario }}">{{ $u->correo }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-400 text-sm mb-2">Rol</label>
                                <select name="id_rol" class="w-full p-3 rounded-lg bg-[#2C2C2C] text-white border border-[#3A3A3A]" required>
                                    @php
                                        $rolUsuario = auth()->user()->getRoleInProject($proyectoSeleccionado->id);
                                    @endphp
                                    @foreach($rol as $r)
                                        @if($rolUsuario === 'Editor' && $r->id == 1)
                                        @else
                                            <option value="{{ $r->id }}">{{ $r->nombre_rol }}</option>
                                        @endif
                                    @endforeach
                                </select>
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
