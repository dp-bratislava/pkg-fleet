<?php

namespace Dpb\Package\Fleet\Services;

use Dpb\Package\Fleet\Entities\VehicleType;
use Dpb\Package\Fleet\Repositories\VehicleTypeRepositoryInterface;

class UpdateVehicleTypeService
{
    public function __construct(
        private VehicleTypeRepositoryInterface $repository,
    ) {}

    public function handle(VehicleType $vehicleType): ?VehicleType
    {
        return $this->repository->save($vehicleType);
    }
}
