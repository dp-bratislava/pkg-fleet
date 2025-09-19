<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Pivot for licence plate history
 */
// class LicencePlateHistory extends Model
class LicencePlateHistory extends Pivot
{
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id', 
        'licence_plate_id', 
        'date_from', 
        'date_to'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_from' => 'date',
            'date_to' => 'date',
        ];
    } 

    public function getTable(): string
    {
        return config('pkg-fleet.table_prefix') . 'licence_plate_history';
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function licencePlate(): BelongsTo
    {
        return $this->belongsTo(LicencePlate::class);
    }
}
