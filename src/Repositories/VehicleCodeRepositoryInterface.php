<?php

namespace Dpb\Package\Fleet\Repositories;

use Dpb\Package\Fleet\Entities\VehicleCode;

interface VehicleCodeRepositoryInterface
{
    public function save(VehicleCode $vehicleCode);
    public function findById(string $id): ?VehicleCode;
    public function findByCode(string $code): ?VehicleCode;
    public function all(): ?array;
    public function byCode(string|array $code): ?array;
}
