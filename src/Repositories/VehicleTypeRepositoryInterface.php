<?php

namespace Dpb\Package\Fleet\Repositories;

use Dpb\Package\Fleet\Entities\VehicleType;

interface VehicleTypeRepositoryInterface
{
    public function save(VehicleType $vehicleType);
    public function findById(string $id): ?VehicleType;
    public function findByCode(string $code): ?VehicleType;
    public function all(): ?array;
    public function byCode(string|array $code): ?array;
}
