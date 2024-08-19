<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSynergyCompTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synergy_comp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('synergy_id')->constrained('synergies')->onDelete('cascade');
            $table->foreignId('composition_id')->constrained('compositions')->onDelete('cascade');
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
        Schema::dropIfExists('synergy_comp');
    }
}
