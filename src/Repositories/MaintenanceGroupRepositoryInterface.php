<?php

namespace Dpb\Package\Fleet\Repositories;

use Dpb\Package\Fleet\Entities\MaintenanceGroup;

interface MaintenanceGroupRepositoryInterface
{
    public function save(MaintenanceGroup $maintenanceGroup);
    public function findById(string $id): ?MaintenanceGroup;
    public function findByCode(string $code): ?MaintenanceGroup;
    public function all(): ?array;
    public function byCode(string|array $code): ?array;
    public function byType(string|array $code): ?array;
}
