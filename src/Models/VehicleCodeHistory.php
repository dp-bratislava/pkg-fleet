<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleCodeHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id', 
        'vehicle_code_id', 
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
        return config('pkg-fleet.table_prefix') . 'vehicle_code_history';
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function code(): BelongsTo
    {
        return $this->belongsTo(VehicleCode::class);
    }
}
