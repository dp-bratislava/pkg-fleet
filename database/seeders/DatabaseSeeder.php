<?php

namespace Dpb\Package\Fleet\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FuelSeeder::class,
            VehicleSeeder::class,
        ]);
    }
}
