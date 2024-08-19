<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAugmentCompTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('augment_comp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('augment_id')->constrained('augments')->onDelete('cascade');
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
        Schema::dropIfExists('augment_comp');
    }
}
