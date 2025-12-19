// Variables globales
let proyectoActual = null;
let arrastrando = null;

document.addEventListener('DOMContentLoaded', () => {
    inicializarKanban();
});

function inicializarKanban() {
    // Configurar drag and drop en las columnas
    configurarDragAndDrop();
}

// Función para cargar tareas de un proyecto
function cargarTareasProyecto(proyectoId) {
    // Mostrar loading
    const kanbanContainer = document.getElementById('kanban-container');
    const proyectoNombre = document.getElementById('proyecto-nombre');
    
    // Fade out si hay un proyecto cargado
    if (proyectoActual !== null) {
        kanbanContainer.style.opacity = '0';
        setTimeout(() => {
            realizarCargaTareas(proyectoId, kanbanContainer, proyectoNombre);
        }, 250);
    } else {
        realizarCargaTareas(proyectoId, kanbanContainer, proyectoNombre);
    }
    
    // Actualizar selección visual del proyecto
    actualizarSeleccionProyecto(proyectoId);
}

function realizarCargaTareas(proyectoId, kanbanContainer, proyectoNombre) {
    fetch(`/canvan/${proyectoId}/tareas`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Error:', data.error);
            return;
        }
        
        // Actualizar nombre del proyecto
        proyectoNombre.textContent = data.proyecto.nombre_proyecto;
        
        // Limpiar columnas
        limpiarColumnas();
        
        // Cargar tareas en cada columna
        cargarTareasEnColumnas(data.tareas, data.estados);
        
        // Fade in
        kanbanContainer.style.opacity = '1';
        
        // Actualizar proyecto actual
        proyectoActual = proyectoId;
        
        // Reconfigurar drag and drop para las nuevas tareas
        configurarDragAndDrop();
    })
    .catch(error => {
        console.error('Error al cargar tareas:', error);
    });
}

function limpiarColumnas() {
    const tareasContainers = document.querySelectorAll('.tareas-container');
    tareasContainers.forEach(container => {
        container.innerHTML = '';
    });
}

function cargarTareasEnColumnas(tareas, estados) {
    estados.forEach(estado => {
        const columna = document.querySelector(`[data-estado-id="${estado.id}"] .tareas-container`);
        const tareasDelEstado = tareas[estado.id] || [];
        
        tareasDelEstado.forEach(tarea => {
            const tareaCard = crearTareaCard(tarea);
            columna.appendChild(tareaCard);
        });
    });
}

function crearTareaCard(tarea) {
    const div = document.createElement('div');
    div.className = 'tarea-card bg-[#3d3d5c] rounded-lg p-4 cursor-move shadow-lg hover:shadow-xl transition-shadow duration-200';
    div.draggable = true;
    div.dataset.tareaId = tarea.id;
    
    // Formatear fecha límite
    const fechaLimite = tarea.fecha_limite ? 
        new Date(tarea.fecha_limite).toLocaleDateString('es-ES') : 
        'Sin fecha límite';
    
    div.innerHTML = `
        <div class="mb-2">
            <h4 class="text-white font-semibold text-sm mb-1 line-clamp-2">${tarea.nombre_tarea}</h4>
        </div>
        <div class="flex justify-between items-center text-xs text-gray-400">
            <span class="flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                ${fechaLimite}
            </span>
        </div>
    `;
    
    return div;
}

function configurarDragAndDrop() {
    // Configurar eventos para las tareas
    const tareas = document.querySelectorAll('.tarea-card');
    tareas.forEach(tarea => {
        tarea.addEventListener('dragstart', handleDragStart);
        tarea.addEventListener('dragend', handleDragEnd);
    });
    
    // Configurar eventos para las columnas
    const columnas = document.querySelectorAll('.kanban-column');
    columnas.forEach(columna => {
        columna.addEventListener('dragover', handleDragOver);
        columna.addEventListener('drop', handleDrop);
        columna.addEventListener('dragenter', handleDragEnter);
        columna.addEventListener('dragleave', handleDragLeave);
    });
}

function handleDragStart(e) {
    arrastrando = this;
    this.classList.add('opacity-50');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.outerHTML);
}

function handleDragEnd(e) {
    this.classList.remove('opacity-50');
    arrastrando = null;
}

function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    e.dataTransfer.dropEffect = 'move';
    return false;
}

function handleDragEnter(e) {
    this.classList.add('bg-[#4d4d6c]');
}

function handleDragLeave(e) {
    this.classList.remove('bg-[#4d4d6c]');
}

function handleDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    
    this.classList.remove('bg-[#4d4d6c]');
    
    if (arrastrando !== this) {
        const tareasContainer = this.querySelector('.tareas-container');
        tareasContainer.appendChild(arrastrando);
        
        // Actualizar estado en el backend
        const tareaId = arrastrando.dataset.tareaId;
        const nuevoEstadoId = this.dataset.estadoId;
        
        actualizarEstadoTarea(tareaId, nuevoEstadoId);
    }
    
    return false;
}

function actualizarEstadoTarea(tareaId, estadoId) {
    fetch(`/tareas/${tareaId}/actualizar-estado`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ estado_id: estadoId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Estado actualizado:', data.mensaje);
        } else {
            console.error('Error al actualizar estado:', data.error);
        }
    })
    .catch(error => {
        console.error('Error en la petición:', error);
    });
}

function actualizarSeleccionProyecto(proyectoId) {
    // Remover selección anterior
    const proyectos = document.querySelectorAll('.proyecto-card');
    proyectos.forEach(proyecto => {
        proyecto.classList.remove('border-blue-500', 'border-4');
    });
    
    // Agregar selección al proyecto actual
    const proyectoSeleccionado = document.querySelector(`[data-proyecto-id="${proyectoId}"]`);
    if (proyectoSeleccionado) {
        proyectoSeleccionado.classList.add('border-blue-500', 'border-4');
    }
}