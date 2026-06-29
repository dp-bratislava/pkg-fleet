<?php
namespace Dpb\Package\Fleet\Observers;

use Dpb\Package\Fleet\Models\Vehicle;
use Dpb\Package\Fleet\Models\VehicleCode;
use Dpb\Package\Fleet\Models\VehicleCodeHistory;
use Dpb\Package\Fleet\Models\LicencePlate;
use Dpb\Package\Fleet\Models\LicencePlateHistory;

class VehicleObserver
{
    public function saved(Vehicle $vehicle): void
    {
        dd('VehicleObserver: saved event triggered for vehicle ID: ');
        $this->handleVehicleCodeHistory($vehicle);
        $this->handleLicencePlateHistory($vehicle);
    }

    protected function handleVehicleCodeHistory(Vehicle $vehicle): void
    {
        $codeValue = $vehicle->getAttribute('code');

        if (blank($codeValue)) {
            return;
        }

        $currentCodeValue = $vehicle->code?->code;

        if ($currentCodeValue === $codeValue) {
            return;
        }

        $newVehicleCode = VehicleCode::firstOrCreate(
            ['code' => $codeValue],
            ['code' => $codeValue]
        );

        if ($vehicle->code) {
            $vehicle->codes()->updateExistingPivot(
                $vehicle->code->id,
                ['date_to' => now()->toDateString()]
            );
        }

        VehicleCodeHistory::query()
            ->where('vehicle_code_id', $newVehicleCode->id)
            ->whereNull('date_to')
            ->update(['date_to' => now()->toDateString()]);

        VehicleCodeHistory::create([
            'vehicle_id' => $vehicle->id,
            'vehicle_code_id' => $newVehicleCode->id,
            'date_from' => now()->toDateString(),
        ]);
    }

    protected function handleLicencePlateHistory(Vehicle $vehicle): void
    {
        // Target attribute name passed by Filament form (e.g., 'licence_plate')
        $plateValue = $vehicle->getAttribute('licence_plate');

        if (blank($plateValue)) {
            return;
        }

        $currentPlateValue = $vehicle->licencePlate?->code;

        if ($currentPlateValue === $plateValue) {
            return;
        }

        $newLicencePlate = LicencePlate::firstOrCreate(
            ['code' => $plateValue],
            ['code' => $plateValue]
        );

        if ($vehicle->licencePlate) {
            $vehicle->licencePlates()->updateExistingPivot(
                $vehicle->licencePlate->id,
                ['date_to' => now()->toDateString()]
            );
        }

        LicencePlateHistory::query()
            ->where('licence_plate_id', $newLicencePlate->id)
            ->whereNull('date_to')
            ->update(['date_to' => now()->toDateString()]);

        LicencePlateHistory::create([
            'vehicle_id' => $vehicle->id,
            'licence_plate_id' => $newLicencePlate->id,
            'date_from' => now()->toDateString(),
        ]);
    }
}