<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateTypeObjectEnumValues extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE items MODIFY COLUMN type_object ENUM('Basic', 'Combined', 'Faerie', 'Radiant', 'Non-Craftable', 'Consumable', 'Support', 'Artifact') NOT NULL");

        DB::statement("UPDATE items SET type_object = 'Non-Craftable' WHERE type_object = 'Non-crafteable'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE items MODIFY COLUMN type_object ENUM('Basic', 'Combined', 'Faerie', 'Radiant', 'Non-crafteable', 'Consumable', 'Support', 'Artifact') NOT NULL");

        DB::statement("UPDATE items SET type_object = 'Non-crafteable' WHERE type_object = 'Non-Craftable'");
    }
}
