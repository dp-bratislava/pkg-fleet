<?php

namespace Dpb\Package\Fleet\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\Uuid;

/**
 * Used in case dabase is handling uuid generation 
 * e.g. uuid_bin column has default value set in db
 */
trait HasBinaryUuidFromDb
{
    /**
     * Convert binary UUID from DB → string UUID automatically.
     */
    public function getUuidAttribute(): ?string
    {
        $column = $this->getBinaryUuidColumn();

        $value = $this->attributes[$column] ?? null;

        return $value
            ? Uuid::fromBytes($value)->toString()
            : null;
    }

    /**
     * Query helper: find by UUID string.
     */
    public function scopeByUuid(Builder $query, string $uuid)
    {
        $query->where(
            static::getBinaryUuidColumnStatic(),
            '=',
            Uuid::fromString($uuid)->getBytes()
        );
    }

    /**
     * Default column name (override if needed).
     */
    public function getBinaryUuidColumn(): string
    {
        return 'uuid_bin';
    }

    /**
     * Static version for queries.
     */
    public static function getBinaryUuidColumnStatic(): string
    {
        return 'uuid_bin';
    }

    /**
     * Default column name (override if needed).
     */
    public function getUuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * Hide binary column from API output.
     */
    protected function initializeHasBinaryUuidFromDb(): void
    {
        $this->hidden[] = $this->getBinaryUuidColumn();
        $this->appends[] = $this->getUuidColumn();
    }
}