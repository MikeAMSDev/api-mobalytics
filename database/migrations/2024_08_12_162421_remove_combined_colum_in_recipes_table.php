<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropForeign(['base_item_id']);
            $table->dropForeign(['combined_item_id']);

            $table->dropColumn('base_item_id');
            $table->dropColumn('combined_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->unsignedBigInteger('base_item_id')->nullable();
            $table->unsignedBigInteger('combined_item_id')->nullable();

            $table->foreign('base_item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('combined_item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }
};