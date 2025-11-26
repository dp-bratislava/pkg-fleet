<?php

namespace Dpb\Package\Fleet\Services;

use Dpb\Package\Fleet\Entities\VehicleGroup;
use Dpb\Package\Fleet\Repositories\VehicleGroupRepositoryInterface;

class CreateVehicleGroupService
{
    public function __construct(
        private VehicleGroupRepositoryInterface $repository,
    ) {}

    public function handle(VehicleGroup $vehicleGroup): ?VehicleGroup
    {
        return $this->repository->save($vehicleGroup);
    }
}
