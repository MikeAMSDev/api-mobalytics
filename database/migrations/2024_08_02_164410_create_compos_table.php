<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compositions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('sinergy')->constrained('synergies');
            $table->string('description');
            $table->string('tier');
            $table->string('difficulty');
            $table->json('prio_carrusel');
            $table->string('playing_style');
            $table->foreignId('augments_id')->constrained('augments');
            $table->string('champ_compo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compositions');
    }
}
