<?php

namespace Dpb\Package\Fleet\Providers;

use Illuminate\Support\Facades\Artisan;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FleetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pkg-fleet')
            ->hasConfigFile()
            ->hasMigrations([
                '0001_create_fleet_tables',
                '0002_add_code_history_table',
                '0003_add_unique_to_vehicle_group_code',
                '0004_add_state_to_vehicle',
                '0005_add_brands_table',
                '0006_create_groups_tables',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function(InstallCommand $command) {
                        $command->info('Installing pkg-eav first...');
                        $command->call('pkg-eav:install');
                        $command->info('Installing ext-spatie-model-states...');
                        $command->call('ext-spatie-model-states:install');
                    })
                    ->publishMigrations()
                    ->publishConfigFile()
                    ->askToRunMigrations();
            });
    }    
}
