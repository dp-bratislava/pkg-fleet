<?php

namespace Dpb\Package\Fleet\Services;

use Dpb\Package\Fleet\Entities\VehicleModel;
use Dpb\Package\Fleet\Repositories\VehicleModelRepositoryInterface;

class CreateVehicleModelService
{
    public function __construct(
        private VehicleModelRepositoryInterface $repository,
    ) {}

    public function handle(VehicleModel $vehicleModel): ?VehicleModel
    {
        return $this->repository->save($vehicleModel);
    }
}
