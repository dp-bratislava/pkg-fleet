<?php

namespace Dpb\Package\Fleet\Repositories;

use Dpb\Package\Fleet\Entities\VehicleModel;

interface VehicleModelRepositoryInterface
{
    public function save(VehicleModel $vehicleModel);
    public function findById(string $id): ?VehicleModel;
    public function all(): ?array;
}
