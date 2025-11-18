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