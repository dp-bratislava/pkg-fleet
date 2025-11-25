<?php

namespace Dpb\Package\Fleet\Entities;

use Carbon\Carbon;

class Vehicle
{
    public function __construct(
        private string $id,
        private ?string $vin,
        private ?VehicleModel $model,
        private string $maintenanceGroupId,
        // private int $constructionYear,
        private array $codes,
        // private int $constructionYear,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function code(): ?VehicleCode
    {
        foreach ($this->codes as $code) {
            if ($code->isCurrent()) {
                return $code;
            }
        }
        return null;
    }

    public function vin(): ?string
    {
        return $this->vin;
    }

    public function maintenanceGroupId(): ?string
    {
        return $this->maintenanceGroupId;
    }

    public function model(): ?VehicleModel
    {
        return $this->model;
    }

    public function updateVin(?string $vin): ?string
    {
        return $this->vin = $vin;
    }

    public function assignModel(VehicleModel $model): VehicleModel
    {
        return $this->model = $model;
    }  

    public function assignMaintenanceGropId(?string $maintenanceGroupId): ?string
    {
        return $this->maintenanceGroupId = $maintenanceGroupId;
    }

    public function updateCode(?VehicleCode $code)
    {
        $current = $this->code();
        if ($current) {
            $current->endToDate(new Carbon());
        }

        $this->codes[] = $code;
    }

    public function codes(): array
    {
        return $this->codes;
    }
}
