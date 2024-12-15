import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Exemple d'animation pour les cartes
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('visible');
        }, 200 * index);
    });

    // Formulaire Ajouter Moût
    setupAddMoutForm();

    // Formulaire Ajouter Propriétaire
    setupAddProprietaireForm();
});

// Formulaire AJAX - Ajouter un Moût
function setupAddMoutForm() {
    const addMoutForm = document.getElementById('addMoutForm');
    if (!addMoutForm) return;

    const url = addMoutForm.getAttribute('data-url');
    addMoutForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(addMoutForm);

        sendAjaxForm(url, formData, 'Moût ajouté avec succès !');
    });
}

// Formulaire AJAX - Ajouter un Propriétaire
function setupAddProprietaireForm() {
    const addProprietaireForm = document.getElementById('addProprietaireForm');
    if (!addProprietaireForm) return;

    const url = addProprietaireForm.getAttribute('data-url');
    addProprietaireForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(addProprietaireForm);

        sendAjaxForm(url, formData, 'Propriétaire ajouté avec succès !');
    });
}

// Fonction générique pour envoyer des formulaires AJAX
function sendAjaxForm(url, formData, successMessage) {
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            toastr.success(successMessage, 'Succès');

            // Délai avant le rechargement de la page
            setTimeout(() => {
                location.reload();
            }, 3000); // 3 secondes
        } else {
            toastr.error(data.message || 'Une erreur est survenue.', 'Erreur');
        }
    })
    .catch((error) => {
        console.error('Erreur AJAX :', error);
        toastr.error('Erreur inattendue.', 'Erreur');
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const dataContainer = document.getElementById('data-container');
    if (!dataContainer) {
        console.log("Pas de data-container trouvé, on arrête.");
        return; // On n'est pas sur la page contenant les graphiques
    }

    // Récupérer les données nécessaires pour les graphiques
    const types = JSON.parse(document.getElementById('types-data').textContent);
    const volumes = JSON.parse(document.getElementById('volumes-data').textContent);
    const cuvesNames = JSON.parse(document.getElementById('cuves-names-data').textContent);
    const cuvesFillRates = JSON.parse(document.getElementById('cuves-fill-data').textContent);

    // Initialisation du premier graphique (volume total des types de moûts)
    const ctxMouts = document.getElementById('moutsChart').getContext('2d');
    new Chart(ctxMouts, {
        type: 'bar',
        data: {
            labels: types,
            datasets: [{
                label: 'Volume Total (L)',
                data: volumes,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Initialisation du second graphique (taux de remplissage des cuves)
    const ctxCuves = document.getElementById('cuvesChart').getContext('2d');
    new Chart(ctxCuves, {
        type: 'bar',
        data: {
            labels: cuvesNames,
            datasets: [{
                label: 'Taux de Remplissage (%)',
                data: cuvesFillRates,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
});