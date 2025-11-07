<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'title',
        'description',
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicle_groups';
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(
            Vehicle::class,
            config('pkg-fleet.table_prefix') . "group_vehicle",
            'group_id',
            'vehicle_id'
        );
    }    

    /**
     * Summary of scopeByCode
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $code
     * @return void
     */
    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = is_array($code) ? $code : [$code];

        $query->whereIn('code', $code);
    }       
}
