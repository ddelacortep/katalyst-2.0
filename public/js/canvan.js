document.addEventListener('DOMContentLoaded', () => {
    const draggables = document.querySelectorAll('.draggable');
    const columns = document.querySelectorAll('[id^="column-"]');

    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', () => {
            draggable.classList.add('dragging');
        });

        draggable.addEventListener('dragend', () => {
            draggable.classList.remove('dragging');
        });
    });

    columns.forEach(column => {
        column.addEventListener('dragover', e => {
            e.preventDefault();
            const dragging = document.querySelector('.dragging');
            column.appendChild(dragging);

            // Aquí puedes hacer una llamada AJAX para actualizar la prioridad en el backend
            const tareaId = dragging.dataset.id;
            const nuevaPrioridadId = column.id.split('-')[1];
            actualizarPrioridad(tareaId, nuevaPrioridadId);
        });
    });

    function actualizarPrioridad(tareaId, nuevaPrioridadId) {
        fetch(`/tareas/${tareaId}/actualizar-prioridad`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ prioridad_id: nuevaPrioridadId }),
        });
    }
});