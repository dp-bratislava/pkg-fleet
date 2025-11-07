<?php

namespace Dpb\Package\Fleet\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleEvent extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'date',
        'vehicle_id',
        'event_type_id',
        'note',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }     

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicle_events';
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, "vehicle_id");
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(VehicleEventType::class, "type_id");
    }

    /**
     * Summary of scopeByType
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $type
     * @return void
     */
    public function scopeByType(Builder $query, string|array $type)
    {
        // cast input to array
        $type = is_array($type) ? $type : [$type];

        $query->whereHas('type', function ($q) use ($type) {
            $q->byCode($type);
        });
    }
}
