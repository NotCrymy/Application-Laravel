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
            $table->decimal('volume_max', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuves');
    }
}