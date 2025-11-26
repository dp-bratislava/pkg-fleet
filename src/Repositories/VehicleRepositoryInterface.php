<?php

namespace Dpb\Package\Fleet\Repositories;

use Dpb\Package\Fleet\Entities\Vehicle;

interface VehicleRepositoryInterface
{
    public function save(Vehicle $vehicle);
    public function findById(string $id): ?Vehicle;
    public function findByCode(string $code): ?Vehicle;
    public function all(): ?array;
    public function byCode(string|array $code): ?array;
    public function byMaintenanceGroup(string|array $code): ?array;
    public function byGroup(string|array $code): ?array;
    public function byType(string|array $code): ?array;
    public function byBrand(string|array $title): ?array;
}
