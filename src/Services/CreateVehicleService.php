<?php

namespace Dpb\Package\Fleet\Services;

use Dpb\Package\Fleet\Entities\Vehicle;
use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;

class CreateVehicleService
{
    public function __construct(
        private VehicleRepositoryInterface $repository,
    ) {}

    public function handle(Vehicle $vehicle): ?Vehicle
    {
        return $this->repository->save($vehicle);
    }
}
