<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyChampionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('champions', function (Blueprint $table) {
            $table->dropColumn('tier');
            $table->string('champion_icon')->after('champion_img');
            $table->json('ability')->after('champion_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('champions', function (Blueprint $table) {
            $table->enum('tier', ['Tier 1', 'Tier 2', 'Tier 3', 'Tier 4', 'Tier 5']);
            $table->dropColumn('champion_icon');
        });
    }
}