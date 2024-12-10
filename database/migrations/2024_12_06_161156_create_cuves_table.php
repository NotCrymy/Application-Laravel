<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuvesTable extends Migration
{
    public function up()
    {
        Schema::create('cuves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->float('volume_max', 2); // En litres
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuves');
    }
}