<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const UUID_COL_NAME = 'uuid_bin';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tablePrefix = config('pkg-fleet.table_prefix');

        $this->addBin16UUID($tablePrefix . "vehicles");
        $this->addBin16UUID($tablePrefix . "vehicle_types");
        $this->addBin16UUID($tablePrefix . "vehicle_models");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tablePrefix = config('pkg-fleet.table_prefix');

        $this->dropBin16UUID($tablePrefix . "vehicles");
        $this->dropBin16UUID($tablePrefix . "vehicle_types");
        $this->dropBin16UUID($tablePrefix . "vehicle_models");
    }

    private function addBin16UUID(string $tableName)
    {
        // vehicles
        Schema::table($tableName, function (Blueprint $table) {
            $table->binary(self::UUID_COL_NAME, 16)->after('id')
                ->nullable();
        });

        // backfill existing rows
        $this->backfillExistingRows($tableName);

        // make not null and set default and set up indexes
        DB::statement("
            ALTER TABLE " . $tableName ."
            MODIFY " . self::UUID_COL_NAME. " BINARY(16)
            NOT NULL
            DEFAULT (UUID_TO_BIN(UUID(), 1))
            COMMENT 'Bin16 representation of UUID for distributed data handling purposes'
        ");

        Schema::table($tableName, function (Blueprint $table) {
            $table->unique(self::UUID_COL_NAME);
        });
    }

    private function backfillExistingRows(string $tableName)
    {
        DB::statement("
            UPDATE " . $tableName . "
            SET " . self::UUID_COL_NAME . " = UUID_TO_BIN(UUID(), 1)
            WHERE " . self::UUID_COL_NAME . " IS NULL
        ");
    }

    private function dropBin16UUID(string $tableName)
    {
        Schema::table($tableName, function (Blueprint $table) {
            $table->dropColumn(self::UUID_COL_NAME);
        });
    }
};
