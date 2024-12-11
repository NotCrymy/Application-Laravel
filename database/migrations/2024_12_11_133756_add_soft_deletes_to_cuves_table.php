<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cuves', function (Blueprint $table) {
            if (!Schema::hasColumn('cuves', 'deleted_at')) {
                $table->softDeletes(); // Ajoute la colonne deleted_at
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuves', function (Blueprint $table) {
            if (Schema::hasColumn('cuves', 'deleted_at')) {
                $table->dropSoftDeletes(); // Supprime la colonne deleted_at
            }
        });
    }
};