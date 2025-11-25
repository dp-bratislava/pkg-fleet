<?php

namespace Dpb\Package\Fleet\Repositories;

use Dpb\Package\Fleet\Entities\VehicleGroup;

interface VehicleGroupRepositoryInterface
{
    public function save(VehicleGroup $vehicleGroup);
    public function findById(string $id): ?VehicleGroup;
    public function findByCode(string $code): ?VehicleGroup;
    public function all(): ?array;
    public function byCode(string|array $code): ?array;
}
