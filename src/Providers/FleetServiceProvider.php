<?php

namespace Dpb\Package\Fleet\Providers;

use Illuminate\Support\Facades\Artisan;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Dpb\Package\Fleet\Models\Vehicle;
use Dpb\Package\Fleet\Observers\VehicleObserver;

class FleetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pkg-fleet')
            ->hasConfigFile()
            ->hasMigrations([
                '2025_01_01_080001_create_fleet_tables',
                '2025_01_01_080002_add_code_history_table',
                '2025_01_01_080003_add_unique_to_vehicle_group_code',
                '2025_01_01_080004_add_state_to_vehicle',
                '2025_01_01_080005_create_brands_table',
                '2025_01_01_080006_create_groups_tables',
                '2025_01_01_080007_create_travel_log_table',
                '2025_01_01_080008_alter_vehicle_models_table',
                '2025_01_01_080009_add_color_to_maintenance_groups_table',
                '2025_01_01_080010_add_maintenance_group_to_vehicles_table',
                '2025_01_01_080011_move_warranty_to_vehicles_table',
                '2025_01_01_080012_add_vehicle_type_to_maintenance_group_table',
                '2025_01_01_080013_create_daily_expeditions_table',
                '2025_01_01_080014_add_is_historic_to_vehicles_table',
            ])
            ->runsMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile();
            });
    }
    
    public function boot(): void
    {
        Vehicle::observe(VehicleObserver::class);
    }
}
