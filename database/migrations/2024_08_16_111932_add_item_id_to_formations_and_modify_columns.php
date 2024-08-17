<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemIdToFormationsAndModifyColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade')->after('compo_id');

            $table->integer('slot_table')->change();

            $table->boolean('star')->default(false)->after('slot_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->integer('slot_table')->change();

            $table->dropColumn('star');

            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        });
    }
}