<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proprietaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('numtel')->nullable();
            $table->string('email')->unique();
            $table->timestamps();
        });

        // Ajout de la relation avec la table mouts
        Schema::table('mouts', function (Blueprint $table) {
            $table->foreignId('proprietaire_id')->nullable()->constrained('proprietaires')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('mouts', function (Blueprint $table) {
            $table->dropForeign(['proprietaire_id']);
            $table->dropColumn('proprietaire_id');
        });

        Schema::dropIfExists('proprietaires');
    }
};
