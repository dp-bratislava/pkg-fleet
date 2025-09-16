<?php

namespace Dpb\Package\Fleet\Database\Seeders;

use App\Models\Fleet\VehicleStatus;
use Dpb\Package\Fleet\Models\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    
    public function run(): void
    {
        $prefix = config('pkg-fleet.table_prefix');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table($prefix . 'vehicle_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // vehicle types
        $statuses = [
            ['code' => 'A', 'title' => 'Autobus'],
            ['code' => 'E', 'title' => 'Električka'],
            ['code' => 'T', 'title' => 'Trolejbus'],
        ];

        foreach ($statuses as $status) {
            VehicleType::create($status);
        }
    }
}