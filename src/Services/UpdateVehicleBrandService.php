<?php

namespace Dpb\Package\Fleet\Services;

use Dpb\Package\Fleet\Entities\VehicleBrand;
use Dpb\Package\Fleet\Repositories\VehicleBrandRepositoryInterface;

class UpdateVehicleBrandService
{
    public function __construct(
        private VehicleBrandRepositoryInterface $repository,
    ) {}

    public function handle(VehicleBrand $vehicleBrand): ?VehicleBrand
    {
        return $this->repository->save($vehicleBrand);
    }
}
