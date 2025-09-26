<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'vin',
        // 'code',
        'model_id',
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicles';
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, "model_id");
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            VehicleGroup::class,
            config('pkg-fleet.table_prefix') . "group_vehicle",
            'vehicle_id',
            'group_id'
        );
    }

    public function licencePlates(): BelongsToMany
    {
        return $this->belongsToMany(
            LicencePlate::class,
            config('pkg-fleet.table_prefix') . "licence_plate_history",
            'vehicle_id',
            'licence_plate_id',
        )
            ->using(LicencePlateHistory::class)
            ->withPivot(['date_from', 'date_to']);
    }

    /**
     * All codes that were used by this vehicle
     * 
     * @return BelongsToMany<VehicleCode, Vehicle, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function codes(): BelongsToMany
    {
        return $this->belongsToMany(
            VehicleCode::class,
            config('pkg-vehicles.table_prefix') . "vehicle_code_history",
            'vehicle_id',
            'vehicle_code_id',
            'id',
            'id'
        )
            ->using(VehicleCodeHistory::class)
            ->withPivot(['date_from', 'date_to']);
    }

    /**
     * Get code currently assigned to this vehicle
     * 
     * @return object|object{pivot: \Illuminate\Database\Eloquent\Relations\Pivot|VehicleCode|null}
     */
    public function getCodeAttribute(): ?VehicleCode
    {
        return $this->codes()
            ->orderByDesc('date_from')
            ->first();
    }

    public function getLicencePlateAttribute()
    {
        return $this->licencePlates()
            ->orderByDesc('date_from')
            ->first()?->code;
    }
}
