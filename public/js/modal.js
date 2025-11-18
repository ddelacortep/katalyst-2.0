function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');  // Quita hidden
    modal.classList.add('flex', 'items-center', 'justify-center');  // Agrega flex y centrado
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('flex', 'items-center', 'justify-center');  // Quita flex y centrado
    modal.classList.add('hidden');     // Agrega hidden para que no se vea
}

function openEditarTareaModal(tareaId, nombreTarea, descripcion, fechaLimite, prioridad, estados) {
    // Actualizar la acción del formulario con el ID de la tarea
    const form = document.getElementById('editarTareaForm');
    form.action = `/tareas/${tareaId}`;
    
    // Rellenar los campos del formulario
    document.getElementById('edit_nombre_tarea').value = nombreTarea || '';
    document.getElementById('edit_descripcion').value = descripcion || '';
    document.getElementById('edit_fecha_limite').value = fechaLimite || '';
    document.getElementById('edit_id_prioridad').value = prioridad || '1';
    document.getElementById('edit_estados').value = estados || '';
    
    // Abrir el modal
    openModal('editarTareaModal');
}