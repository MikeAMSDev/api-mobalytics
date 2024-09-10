<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeInCompositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->enum('type', ['private', 'publish', 'meta'])->default('private')->after('likes');
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
            $table->dropColumn('type');
        });
    }
}