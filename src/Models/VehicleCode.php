<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleCode extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicle_codes';
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(
            Vehicle::class,
            config('pkg-fleet.table_prefix') . "vehicle_code_history",
            'vehicle_code_id',
            'vehicle_id',
            'id',
            'id'
        )
            ->using(VehicleCodeHistory::class)
            ->withPivot(['date_from', 'date_to']);
    }

    /**
     * Get vehicle currently assigned to this code
     * 
     * @return object|object{pivot: \Illuminate\Database\Eloquent\Relations\Pivot|Vehicles|null}
     */
    public function getVehicleAttribute(): ?Vehicle
    {
        return $this->vehicles()
            ->orderByDesc('date_from')
            ->first();
    }

}
