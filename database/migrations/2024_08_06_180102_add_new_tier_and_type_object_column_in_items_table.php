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
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('tier')->constrained('tiers');
            $table->enum('type_object', ['Basic', 'Combined', 'Faerie', 'Radiant', 'Non-crafteable', 'Consumable', 'Support', 'Artifact']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['tier']);
            $table->string('type_object');
        });
    }
};
