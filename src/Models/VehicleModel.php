<?php

namespace Dpb\Package\Fleet\Models;

use Dpb\Package\Eav\Traits\HasAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'type_id',
        'brand_id',
        'length',
        'seats',
        'fuel_type_id',
        'alternate_fuel_type_id',
        'year',
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicle_models';
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, "brand_id");
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

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, "model_id");
    }    

    public function scopeByType(Builder $query, string|array $type)
    {
        // cast input to array
        $type = is_array($type) ? $type : [$type];

        $query->whereHas('type', function ($q) use ($type) {
            $q->byCode($type);
        });
    }

    public function scopeByTypeIds(Builder $query, array $typeIds)
    {
        $query->whereIn('type_id', $typeIds);
    }

    public function scopeByBrand(Builder $query, string|array $brand)
    {
        // cast input to array
        $brand = is_array($brand) ? $brand : [$brand];

        $query->whereHas('brand', function ($q) use ($brand) {
            $q->whereIn('title', $brand);
        });
    }    


}
