<?php

namespace Dpb\Package\Fleet\Models;

use Dpb\Package\Eav\Traits\HasAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleModel extends Model
{
    use SoftDeletes;    
    use HasAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'warranty',
        'type_id',
        'year',
        'length',
        'tank_size',
        'seats',
        'fuel_type_id',
        'alternate_fuel_type_id',
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicle_models';
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, "type_id");
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class, "fuel_type_id");
    }

    public function alternateFuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class, "alternate_fuel_type_id");
    }

    public function fuelConsumptonTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            FuelConsumptionType::class,
            config('pkg-fleet.table_prefix') . "vehicle_model_fuel_consumption",
            'model_id',
            'consumption_type_id'
        );
    }
}
