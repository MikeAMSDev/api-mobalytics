<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDescriptionModifyRecipesidAndRemoveTierToItemBonusInItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('description', 'item_bonus');

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
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('item_bonus', 'description');

            $table->foreignId('tier')->constrained('tiers');

        });
    }
}
