<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations pour créer les tables nécessaires.
     */
    public function up(): void
    {
        // Création de la table 'users' pour stocker les informations des utilisateurs
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Identifiant unique (clé primaire)
            $table->string('name'); // Nom de l'utilisateur
            $table->string('email')->unique(); // Email unique pour chaque utilisateur
            $table->timestamp('email_verified_at')->nullable(); // Date de vérification de l'email (peut être nul)
            $table->string('password'); // Mot de passe hashé
            $table->rememberToken(); // Token pour "remember me" (connexion persistante)
            $table->timestamps(); // Colonnes 'created_at' et 'updated_at'
        });

        // Création de la table 'password_reset_tokens' pour gérer les réinitialisations de mot de passe
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email en tant que clé primaire
            $table->string('token'); // Token de réinitialisation
            $table->timestamp('created_at')->nullable(); // Date de création du token
        });

        // Création de la table 'sessions' pour stocker les sessions des utilisateurs
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID unique de la session
            $table->foreignId('user_id')->nullable()->index(); // Clé étrangère vers 'users', peut être null
            $table->string('ip_address', 45)->nullable(); // Adresse IP de l'utilisateur
            $table->text('user_agent')->nullable(); // Informations sur le navigateur ou l'appareil
            $table->longText('payload'); // Données de la session
            $table->integer('last_activity')->index(); // Timestamp de la dernière activité
        });
    }

    /**
     * Annule les migrations et supprime les tables.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Supprime la table 'users'
        Schema::dropIfExists('password_reset_tokens'); // Supprime la table 'password_reset_tokens'
        Schema::dropIfExists('sessions'); // Supprime la table 'sessions'
    }
};