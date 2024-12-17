<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations pour créer les tables de cache et de verrouillage de cache.
     */
    public function up(): void
    {
        // Création de la table 'cache' pour stocker les données mises en cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Clé unique pour identifier la donnée mise en cache
            $table->mediumText('value'); // Valeur associée à la clé
            $table->integer('expiration'); // Timestamp pour la date d'expiration de la cache
        });

        // Création de la table 'cache_locks' pour gérer les verrous sur la cache
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Clé unique pour identifier le verrou
            $table->string('owner'); // Propriétaire du verrou (ex : processus)
            $table->integer('expiration'); // Timestamp pour la date d'expiration du verrou
        });
    }

    /**
     * Annule les migrations et supprime les tables.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache'); // Supprime la table 'cache'
        Schema::dropIfExists('cache_locks'); // Supprime la table 'cache_locks'
    }
};