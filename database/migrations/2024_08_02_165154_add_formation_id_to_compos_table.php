<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormationIdToComposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('set null');
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

            $table->dropForeign(['formation_id']);
            $table->dropColumn('formation_id');
        });
    }
}
