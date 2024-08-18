<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateTypeObjectEnumValues extends Migration
{
    public function up()
    {
        $connection = config('database.default');

        if ($connection === 'pgsql') {
            DB::statement("ALTER TABLE items ALTER COLUMN type_object TYPE VARCHAR(255)");

            DB::statement("ALTER TABLE items ADD CONSTRAINT check_type_object CHECK (type_object IN ('Basic', 'Combined', 'Faerie', 'Radiant', 'Non-Craftable', 'Consumable', 'Support', 'Artifact'))");

            DB::statement("UPDATE items SET type_object = 'Non-Craftable' WHERE type_object = 'Non-crafteable'");
        } elseif ($connection === 'mysql') {
            DB::statement("ALTER TABLE items MODIFY COLUMN type_object ENUM('Basic', 'Combined', 'Faerie', 'Radiant', 'Non-Craftable', 'Consumable', 'Support', 'Artifact') NOT NULL");

            DB::statement("UPDATE items SET type_object = 'Non-Craftable' WHERE type_object = 'Non-crafteable'");
        } else {
            throw new Exception("Database connection [$connection] not supported.");
        }
    }

    public function down()
    {
        $connection = config('database.default');

        if ($connection === 'pgsql') {
            DB::statement("ALTER TABLE items DROP CONSTRAINT check_type_object");

            DB::statement("UPDATE items SET type_object = 'Non-crafteable' WHERE type_object = 'Non-Craftable'");
        } elseif ($connection === 'mysql') {
            DB::statement("ALTER TABLE items MODIFY COLUMN type_object ENUM('Basic', 'Combined', 'Faerie', 'Radiant', 'Non-crafteable', 'Consumable', 'Support', 'Artifact') NOT NULL");

            DB::statement("UPDATE items SET type_object = 'Non-crafteable' WHERE type_object = 'Non-Craftable'");
        } else {
            throw new Exception("Database connection [$connection] not supported.");
        }
    }
}