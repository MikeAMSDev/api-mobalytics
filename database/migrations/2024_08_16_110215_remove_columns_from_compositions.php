<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromCompositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->dropForeign(['sinergy']);
            $table->dropColumn('sinergy');

            $table->dropForeign(['augments_id']);
            $table->dropColumn('augments_id');

            $table->dropColumn('champ_compo');

            $table->dropForeign(['formation_id']);
            $table->dropColumn('formation_id');

            $table->dropForeign(['tier']);
            $table->dropColumn('tier');

            $table->dropForeign(['difficulty']);
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
        Schema::table('compositons', function (Blueprint $table) {
            $table->foreignId('sinergy')->constrained('synergies');
            $table->foreignId('augments_id')->constrained('augments');
            $table->string('champ_compo');
            $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('set null');
            $table->foreignId('tier')->constrained('tiers')->before('champ_compo');
            $table->foreignId('difficulty')->constrained('difficulties')->before('tier');
        });
    }
}
