<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifySetVersionAndTierInAugmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('augments', function (Blueprint $table) {
            $table->dropColumn('set_version');
            $table->dropColumn('tier');
        });

        Schema::table('augments', function (Blueprint $table) {
            $table->unsignedTinyInteger('set_version');
        });

        DB::statement('ALTER TABLE augments ADD CONSTRAINT set_version_check CHECK (set_version BETWEEN 1 AND 12)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement('ALTER TABLE augments DROP CONSTRAINT set_version_check');

        Schema::table('augments', function (Blueprint $table) {

            $table->dropColumn('set_version');
        });

        Schema::table('augments', function (Blueprint $table) {

            $table->enum('set_version', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
            $table->enum('tier', ['Tier 1', 'Tier 2', 'Tier 3']);
        });
    }
}
