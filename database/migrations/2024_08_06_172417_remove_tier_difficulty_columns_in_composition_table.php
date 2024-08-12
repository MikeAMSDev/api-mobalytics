<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTierDifficultyColumnsInCompositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->dropColumn('tier');
            $table->dropColumn('difficulty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->string('tier');
            $table->string('difficulty');
        });
    }
}
