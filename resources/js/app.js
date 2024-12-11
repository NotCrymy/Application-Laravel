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

// Formulaire AJAX
document.addEventListener("DOMContentLoaded", function () {
    const addMoutForm = document.getElementById("addMoutForm");

    if (addMoutForm) {
        addMoutForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(addMoutForm);
            const cuveId = window.location.pathname.split("/")[2]; // Récupère l'ID de la cuve depuis l'URL
            
            fetch(`/cuves/${cuveId}/mouts`, {
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
                    alert("Moût ajouté avec succès !");
                    location.reload(); // Recharge la page pour mettre à jour la liste
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
        addProprietaireForm.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(addProprietaireForm);
            fetch("{{ route('proprietaires.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content,
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
