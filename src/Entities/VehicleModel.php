<?php

namespace Dpb\Package\Fleet\Entities;

class VehicleModel
{
    public function __construct(
        private string $id,
        private string $title,
        private ?string $year,
        private ?VehicleType $type,
        private ?VehicleBrand $brand,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function year(): ?string
    {
        return $this->year;
    }

    public function type(): ?VehicleType
    {
        return $this->type;
    }

    public function brand(): ?VehicleBrand
    {
        return $this->brand;
    }

    public function rename(string $newTitle): ?string
    {
        return $this->title = $newTitle;
    }

    public function updateYear(?string $year): ?string
    {
        return $this->year = $year;
    }

    public function assignType(?VehicleType $type): ?VehicleType
    {
        return $this->type = $type;
    }
    
    public function assignBrand(?VehicleBrand $brand): ?VehicleBrand
    {
        return $this->brand = $brand;
    }    
}
