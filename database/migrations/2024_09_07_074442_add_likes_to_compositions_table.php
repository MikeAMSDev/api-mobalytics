<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesToCompositionsTable extends Migration
{
    public function up()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->unsignedInteger('likes')->default(0)->after('difficulty');
        });
    }

    public function down()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->dropColumn('likes');
        });
    }
}