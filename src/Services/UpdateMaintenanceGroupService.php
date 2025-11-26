<?php

namespace Dpb\Package\Fleet\Services;

use Dpb\Package\Fleet\Entities\MaintenanceGroup;
use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;

class UpdateMaintenanceGroupService
{
    public function __construct(
        private MaintenanceGroupRepositoryInterface $repository,
    ) {}

    public function handle(MaintenanceGroup $maintenanceGroup): ?MaintenanceGroup
    {
        return $this->repository->save($maintenanceGroup);
    }
}
