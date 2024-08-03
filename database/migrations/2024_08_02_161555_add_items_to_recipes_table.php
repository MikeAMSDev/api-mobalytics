<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsToRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->unsignedBigInteger('base_item_id')->nullable();
            $table->unsignedBigInteger('combined_item_id')->nullable();

            $table->foreign('base_item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('combined_item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropForeign(['base_item_id']);
            $table->dropForeign(['combined_item_id']);
            $table->dropColumn('base_item_id');
            $table->dropColumn('combined_item_id');
        });
    }
}
