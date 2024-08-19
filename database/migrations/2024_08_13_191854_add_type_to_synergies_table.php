<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToSynergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('synergies', function (Blueprint $table) {
            $table->string('type')->after('name');
            $table->text('description')->change();
            $table->dropColumn('synergy_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('synergies', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->string('description')->change();
            $table->string('synergy_img')->nullable();
        });
    }
}