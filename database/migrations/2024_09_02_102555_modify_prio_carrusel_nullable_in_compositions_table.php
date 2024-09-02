<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPrioCarruselNullableInCompositionsTable extends Migration
{
    public function up()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->dropColumn('prio_carrusel');
        });
    }

    public function down()
    {
        Schema::table('compositions', function (Blueprint $table) {
            $table->json('prio_carrusel');
        });
    }
}