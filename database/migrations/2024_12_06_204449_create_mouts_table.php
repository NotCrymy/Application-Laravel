<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoutsTable extends Migration
{
    /**
     * Exécute la migration pour créer la table 'mouts'.
     */
    public function up()
    {
        Schema::create('mouts', function (Blueprint $table) {
            $table->id(); // Identifiant unique (clé primaire)
            $table->string('type'); // Type de moût
            $table->string('origine'); // Origine du moût
            $table->float('volume', 8); // Volume du moût (8 chiffres avant la virgule)
            $table->foreignId('cuve_id') // Clé étrangère vers la table 'cuves'
                  ->constrained() // Ajoute la contrainte de clé étrangère
                  ->onDelete('cascade'); // Suppression en cascade si la cuve est supprimée
            $table->timestamps(); // Colonnes 'created_at' et 'updated_at'
        });
    }

    /**
     * Annule la migration et supprime la table 'mouts'.
     */
    public function down()
    {
        Schema::dropIfExists('mouts'); // Supprime la table 'mouts' si elle existe
    }
}