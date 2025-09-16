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
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->publishConfigFile()
                    ->askToRunMigrations()
                    ->endWith(function () {
                        // Artisan::call('db:seed', [
                        //     '--class' => \Dpb\Package\Fleet\Database\Seeders\DatabaseSeeder::class,
                        //     '--force' => true,
                        // ]);
                    });
            });
    }    
}
