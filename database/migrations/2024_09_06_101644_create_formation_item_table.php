<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationItemTable extends Migration
{
    public function up()
    {
        Schema::create('formation_item', function (Blueprint $table) {
            $table->id();

            $table->foreignId('formation_id')->nullable()->constrained('formations')->onDelete('cascade');

            $table->foreignId('item_id')->nullable()->constrained('items')->onDelete('cascade');

            $table->foreignId('compo_id')->nullable()->constrained('compositions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('formation_item');
    }
}