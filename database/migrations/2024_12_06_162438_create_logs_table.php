<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Exécute la migration pour créer la table 'logs'.
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id(); // Identifiant unique (clé primaire)
            $table->foreignId('user_id') // Clé étrangère vers la table 'users'
                  ->constrained(); // Ajoute automatiquement la contrainte de clé étrangère
            $table->text('action'); // Description de l'action effectuée par l'utilisateur
            $table->timestamps(); // Colonnes 'created_at' et 'updated_at'
        });
    }

    /**
     * Annule la migration et supprime la table 'logs'.
     */
    public function down()
    {
        Schema::dropIfExists('logs'); // Supprime la table 'logs' si elle existe
    }
}