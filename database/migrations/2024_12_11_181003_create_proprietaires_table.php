<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Exécute la migration pour créer la table 'proprietaires' 
     * et ajouter la relation avec la table 'mouts'.
     */
    public function up(): void
    {
        // Création de la table 'proprietaires'
        Schema::create('proprietaires', function (Blueprint $table) {
            $table->id(); // Identifiant unique (clé primaire)
            $table->string('nom'); // Nom du propriétaire
            $table->string('prenom'); // Prénom du propriétaire
            $table->string('numtel')->nullable(); // Numéro de téléphone (facultatif)
            $table->string('email')->unique(); // Email unique du propriétaire
            $table->timestamps(); // Colonnes 'created_at' et 'updated_at'
        });

        // Ajout de la clé étrangère 'proprietaire_id' dans la table 'mouts'
        Schema::table('mouts', function (Blueprint $table) {
            $table->foreignId('proprietaire_id') // Clé étrangère vers 'proprietaires'
                  ->nullable() // Peut être nul
                  ->constrained('proprietaires'); // Contrainte de clé étrangère
        });
    }

    /**
     * Annule la migration en supprimant la relation et la table 'proprietaires'.
     */
    public function down(): void
    {
        // Suppression de la clé étrangère et de la colonne dans 'mouts'
        Schema::table('mouts', function (Blueprint $table) {
            $table->dropForeign(['proprietaire_id']); // Suppression de la contrainte de clé étrangère
            $table->dropColumn('proprietaire_id'); // Suppression de la colonne
        });

        // Suppression de la table 'proprietaires'
        Schema::dropIfExists('proprietaires');
    }
};