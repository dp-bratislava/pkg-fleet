<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'brands';
    }

    public function models(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
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
