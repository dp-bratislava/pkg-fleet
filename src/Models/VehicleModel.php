<?php

namespace Dpb\Package\Fleet\Models;

use Dpb\Package\Eav\Traits\HasAttributes;
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
        'warranty',
        'type_id',
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

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, "model_id");
    }    
}
