<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAugmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('augments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('augment_img');
            $table->enum('tier', ['Tier 1', 'Tier 2', 'Tier 3']);
            $table->enum('set_version', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
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
        Schema::dropIfExists('augments');
    }
}