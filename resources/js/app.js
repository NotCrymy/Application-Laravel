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

// Formulaire AJAX Mout
document.addEventListener("DOMContentLoaded", function () {
    const addMoutForm = document.getElementById("addMoutForm");

    if (addMoutForm) {
        const moutUrl = addMoutForm.getAttribute('data-url');

        addMoutForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(addMoutForm);

            fetch(moutUrl, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json",
                },
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Pour mettre à jour la liste des moûts
                } else {
                    alert(data.message || "Erreur lors de l'ajout du moût.");
                }
            })
            .catch((error) => console.error("Erreur AJAX :", error));
        });
    }
});

// Formulaire AJAX Propriétaire
document.addEventListener("DOMContentLoaded", function () {
    const addProprietaireForm = document.getElementById("addProprietaireForm");
    if (addProprietaireForm) {
        const proprietaireUrl = addProprietaireForm.getAttribute('data-url');

        addProprietaireForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(addProprietaireForm);

            fetch(proprietaireUrl, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json",
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Propriétaire ajouté avec succès !");
                    location.reload(); 
                } else {
                    alert(data.message || "Erreur lors de l'ajout du propriétaire.");
                }
            })
            .catch((error) => console.error("Erreur AJAX :", error));
        });
    }
});


// Chart etat des cuves
document.addEventListener("DOMContentLoaded", function() {
    const dataContainer = document.getElementById('data-container');
    if (!dataContainer) {
        console.log("Pas de data-container trouvé, on arrête.");
        return; // On n'est pas sur la page etat des cuves
    }

    // Récupérer les données
    const types = JSON.parse(document.getElementById('types-data').textContent);
    const volumes = JSON.parse(document.getElementById('volumes-data').textContent);
    const cuvesNames = JSON.parse(document.getElementById('cuves-names-data').textContent);
    const cuvesFillRates = JSON.parse(document.getElementById('cuves-fill-data').textContent);

    // Initialiser Chart.js sur moutsChart
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

    // Initialiser Chart.js sur cuvesChart
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
