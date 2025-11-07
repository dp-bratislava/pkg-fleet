<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceGroup extends Model
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
        'color',
    ];

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'maintenance_groups';
    }

    public function vehicles() : HasMany {
        return $this->hasMany(Vehicle::class);
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
