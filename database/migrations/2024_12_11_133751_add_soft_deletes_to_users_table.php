<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute la migration pour ajouter la colonne 'deleted_at' dans la table 'users'.
     */
    public function up()
    {
        // Vérifie si la colonne 'deleted_at' n'existe pas déjà
        if (!Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->softDeletes(); // Ajoute la colonne 'deleted_at' pour le soft delete
            });
        }
    }

    /**
     * Annule la migration en supprimant la colonne 'deleted_at'.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Supprime la colonne 'deleted_at' si elle existe
        });
    }
};