// Importer Bootstrap JS
import 'bootstrap';

// Animation pour les cartes
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('visible');
        }, 200 * index);
    });
});
