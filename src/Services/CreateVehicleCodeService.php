<?php

namespace Dpb\Package\Fleet\Services;

use Dpb\Package\Fleet\Entities\VehicleCode;
use Dpb\Package\Fleet\Repositories\VehicleCodeRepositoryInterface;

class CreateVehicleCodeService
{
    public function __construct(
        private VehicleCodeRepositoryInterface $repository,
    ) {}

    public function handle(VehicleCode $vehicleCode): ?VehicleCode
    {
        return $this->repository->save($vehicleCode);
    }
}
