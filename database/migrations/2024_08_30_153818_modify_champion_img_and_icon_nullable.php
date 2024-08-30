<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyChampionImgAndIconNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('champions', function (Blueprint $table) {
            $table->string('champion_img')->nullable()->change();
            $table->string('champion_icon')->nullable()->change();
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
            $table->string('champion_img')->nullable(false)->change();
            $table->string('champion_icon')->nullable(false)->change();
        });
    }
}
