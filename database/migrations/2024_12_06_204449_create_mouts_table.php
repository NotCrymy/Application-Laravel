<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoutsTable extends Migration
{
    public function up()
    {
        Schema::create('mouts', function (Blueprint $table) {
            $table->id();
            $table->decimal('volume', 10, 2);
            $table->string('type');
            $table->string('origine');
            $table->foreignId('cuve_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mouts');
    }
}