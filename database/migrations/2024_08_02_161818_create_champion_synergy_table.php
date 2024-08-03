<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionSynergyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('champion_synergy', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('champion_id');
            $table->unsignedBigInteger('synergy_id');
            $table->timestamps();

            $table->foreign('champion_id')->references('id')->on('champions')->onDelete('cascade');
            $table->foreign('synergy_id')->references('id')->on('synergies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('champion_synergy');
    }
}
