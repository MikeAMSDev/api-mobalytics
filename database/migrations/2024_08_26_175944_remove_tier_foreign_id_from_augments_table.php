<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTierForeignIdFromAugmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('augments', function (Blueprint $table) {
            $table->dropForeign(['tier']);

            $table->dropColumn('tier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_name', function (Blueprint $table) {
            // Vuelve a agregar la columna 'tier' como foreignId
            $table->foreignId('tier')->constrained('tiers');
        });
    }
}