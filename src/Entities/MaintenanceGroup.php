<?php

namespace Dpb\Package\Fleet\Entities;

class MaintenanceGroup
{
    public function __construct(
        private string $id,
        private string $code,
        private string $title,
        private ?string $description,
        private ?VehicleType $vehicleType,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function title(): string
    {
        return $this->title;
    }
    
    public function description(): ?string
    {
        return $this->description;
    }    

    public function vehicleType(): ?VehicleType
    {
        return $this->vehicleType;
    }    

    public function rename(string $newTitle): ?string
    {
        return $this->title = $newTitle;
    }    

    public function updateDescription(?string $description): ?string
    {
        return $this->description = $description;
    }    

    public function updateCode(?string $code): ?string
    {
        return $this->code = $code;
    }     

    public function assignVehicleType(?VehicleType $vehicleType): ?VehicleType
    {
        return $this->vehicleType = $vehicleType;
    }        
}
