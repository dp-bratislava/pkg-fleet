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
        $tablePrefix = config('pkg-fleet.table_prefix');

        // vehicle state
        Schema::table($tablePrefix . 'vehicles', function (Blueprint $table) {
            $table->boolean('is_historic')
                ->default(false)
                ->comment("Indicates if the vehicle is a historic show off vehicle");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tablePrefix = config('pkg-fleet.table_prefix');

        Schema::table($tablePrefix . 'vehicles', function (Blueprint $table) {
            $table->dropColumn('is_historic');
        });
    }
};
