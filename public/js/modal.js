function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');  // Quita hidden
    modal.classList.add('flex');       // Agrega flex para que se vea
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('flex');    // Quita flex
    modal.classList.add('hidden');     // Agrega hidden para que no se vea
}