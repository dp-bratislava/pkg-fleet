<?php

namespace Dpb\Package\Fleet\Database\Seeders;

use App\Models\Fleet\VehicleStatus;
use Dpb\Package\Fleet\Models\FuelConsumptionType;
use Dpb\Package\Fleet\Models\FuelType;
use Dpb\Package\Fleet\Models\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuelSeeder extends Seeder
{
    protected $prefix = config('pkg-fleet.table_prefix');

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table($this->prefix . 'fuel_types')->truncate();
        DB::table($this->prefix . 'fuel_consumption_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // fuel types
        $fuelTypes = [
            ['code' => 'A', 'title' => 'Autobus'],
            ['code' => 'E', 'title' => 'Električka'],
            ['code' => 'T', 'title' => 'Trolejbus'],
        ];

        foreach ($fuelTypes as $fuelType) {
            FuelType::create($fuelType);
        }

        // fuel consumption types
        $consumptionTypes = [
           ['code' => 'fuel_consumption', 'description' => 'Fuel consumption out of city'],
           ['code' => 'fuel_consumption_city', 'description' => 'Fuel consumption inside city'],
           ['code' => 'fuel_consumption_combined', 'description' => 'Fuel consumption combined'],
           ['code' => 'std_fuel_consumption_winter', 'description' => 'Standardised fuel consumption out of city in winter'],
           ['code' => 'std_fuel_consumption_city_winter', 'description' => 'Standardised fuel consumption inside city in winter'],
           ['code' => 'std_fuel_consumption_summer', 'description' => 'Standardised fuel consumption out of city in summer'],
           ['code' => 'std_fuel_consumption_city_summer', 'description' => 'Standardised fuel consumption inside city in summer'],
        ];

        foreach ($consumptionTypes as $consumptionType) {
            FuelConsumptionType::create($consumptionType);
        }
    }
}