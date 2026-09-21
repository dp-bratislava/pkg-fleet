<?php 

namespace Dpb\Package\Fleet\Services;

use Illuminate\Database\Eloquent\Model;
use Dpb\Package\Fleet\Models\VehicleCode;
use Dpb\Package\Fleet\Models\VehicleCodeHistory;
use Dpb\Package\Fleet\Models\LicencePlate;
use Dpb\Package\Fleet\Models\LicencePlateHistory;
use Illuminate\Support\Facades\DB;

class VehicleHistoryService
{
    public function handle(Model $vehicle, array $data): Model
    {
        return DB::transaction(function () use ($vehicle, $data) {
            $codeValue = $data['code'] ?? null;
            $plateValue = $data['licence_plate'] ?? null;

            // Save primary Vehicle record
            $vehicle->fill($data)->save();

            // Handle related history tracking
            $this->handleCodeHistory($vehicle, $codeValue);
            $this->handlePlateHistory($vehicle, $plateValue);

            return $vehicle;
        });
    }

    protected function handleCodeHistory(Model $vehicle, ?string $codeValue): void
    {
        if (blank($codeValue) || $vehicle->code?->code === $codeValue) {
            return;
        }

        $newCode = VehicleCode::firstOrCreate(
            ['code' => $codeValue],
            ['code' => $codeValue]
        );

        VehicleCodeHistory::query()
            ->where('vehicle_id', $vehicle->id)
            ->whereNull('date_to')
            ->update(['date_to' => now()->toDateString()]);

        VehicleCodeHistory::create([
            'vehicle_id' => $vehicle->id,
            'vehicle_code_id' => $newCode->id,
            'date_from' => now()->toDateString(),
        ]);
    }

    protected function handlePlateHistory(Model $vehicle, ?string $plateValue): void
    {
        if (blank($plateValue) || $vehicle->licencePlate?->code === $plateValue) {
            return;
        }

        $newPlate = LicencePlate::firstOrCreate(
            ['code' => $plateValue],
            ['code' => $plateValue]
        );

        LicencePlateHistory::query()
            ->where('vehicle_id', $vehicle->id)
            ->whereNull('date_to')
            ->update(['date_to' => now()->toDateString()]);

        LicencePlateHistory::create([
            'vehicle_id' => $vehicle->id,
            'licence_plate_id' => $newPlate->id,
            'date_from' => now()->toDateString(),
        ]);
    }
}