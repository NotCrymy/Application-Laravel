<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuvesTable extends Migration
{
    /**
     * Exécute la migration pour créer la table 'cuves'.
     */
    public function up()
    {
        Schema::create('cuves', function (Blueprint $table) {
            $table->id(); // Identifiant unique (clé primaire)
            $table->string('nom'); // Nom de la cuve
            $table->float('volume_max', 8); // Capacité maximale de la cuve en litres
            $table->timestamps(); // Colonnes 'created_at' et 'updated_at'
        });
    }

    /**
     * Annule la migration et supprime la table 'cuves'.
     */
    public function down()
    {
        Schema::dropIfExists('cuves'); // Supprime la table si elle existe
    }
}