<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioCarruselTable extends Migration
{
    public function up()
    {
        Schema::create('prio_carrusel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('composition_id')->constrained('compositions')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prio_carrusel');
    }
}
