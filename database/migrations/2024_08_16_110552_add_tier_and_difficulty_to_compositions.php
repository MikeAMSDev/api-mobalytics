<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTierAndDifficultyToCompositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->enum('tier', ['S', 'A', 'B', 'M', 'N'])->after('playing_style');
            $table->enum('difficulty', ['Easy', 'Medium', 'Hard'])->after('tier');
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
            $table->dropColumn('tier');
            $table->dropColumn('difficulty');
        });
    }
}