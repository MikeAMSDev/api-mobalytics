<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeItemIdNullableInFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->foreignId('item_id')->nullable()->change();
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
            $table->foreignId('item_id')->nullable(false)->change();
        });
    }
}