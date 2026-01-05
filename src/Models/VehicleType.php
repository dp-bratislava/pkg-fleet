<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleType extends Model
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
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicle_types';
    }

    public function models(): HasMany
    {
        return $this->hasMany(VehicleModel::class, "type_id");
    }

    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = is_array($code) ? $code : [$code];

        $query->whereIn('code', $code);
    }

    public function scopeByIds(Builder $query, array $ids)
    {
        $query->whereIn('id', $ids);
    }    
}
