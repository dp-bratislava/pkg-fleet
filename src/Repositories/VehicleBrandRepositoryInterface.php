<?php

namespace Dpb\Package\Fleet\Repositories;

use Dpb\Package\Fleet\Entities\VehicleBrand;

interface VehicleBrandRepositoryInterface
{
    public function save(VehicleBrand $vehicleBrand);
    public function findById(string $id): ?VehicleBrand;
    public function all(): ?array;
}
