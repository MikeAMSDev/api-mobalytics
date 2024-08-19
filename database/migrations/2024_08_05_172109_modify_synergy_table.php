<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifySynergyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('synergies', function (Blueprint $table) {
            $table->dropColumn('set_version');
        });

        Schema::table('synergies', function (Blueprint $table) {
            $table->unsignedTinyInteger('set_version');
        });

        DB::statement('ALTER TABLE synergies ADD CONSTRAINT set_version_check CHECK (set_version BETWEEN 1 AND 12)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement('ALTER TABLE synergies DROP CONSTRAINT set_version_check');

        Schema::table('synergies', function (Blueprint $table) {

            $table->dropColumn('set_version');
        });

        Schema::table('synergies', function (Blueprint $table) {

            $table->tinyInteger('set_version')->unsigned();
        });
    }
}
