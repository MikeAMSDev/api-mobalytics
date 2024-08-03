<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('champions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('cost', ['1', '2', '3', '4', '5']);
            $table->enum('tier', ['Tier 1', 'Tier 2', 'Tier 3', 'Tier 4', 'Tier 5']);
            $table->string('champion_img');
            $table->unsignedTinyInteger('set_version')->check('set_version BETWEEN 1 AND 12');
            $table->json('stats');
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
        Schema::dropIfExists('champions');
    }
}