<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute la migration pour ajouter la colonne 'deleted_at' à la table 'cuves'.
     */
    public function up(): void
    {
        Schema::table('cuves', function (Blueprint $table) {
            // Vérifie si la colonne 'deleted_at' n'existe pas déjà
            if (!Schema::hasColumn('cuves', 'deleted_at')) {
                $table->softDeletes(); // Ajoute la colonne 'deleted_at' pour permettre le soft delete
            }
        });
    }

    /**
     * Annule la migration en supprimant la colonne 'deleted_at' de la table 'cuves'.
     */
    public function down(): void
    {
        Schema::table('cuves', function (Blueprint $table) {
            // Vérifie si la colonne 'deleted_at' existe avant de la supprimer
            if (Schema::hasColumn('cuves', 'deleted_at')) {
                $table->dropSoftDeletes(); // Supprime la colonne 'deleted_at'
            }
        });
    }
};