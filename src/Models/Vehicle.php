<?php

namespace Dpb\Package\Fleet\Models;

use Dpb\Extension\ModelState\Traits\HasStateHistory;
use Dpb\Package\Fleet\States\VehicleState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Spatie\ModelStates\HasStates;
use Spatie\ModelStates\HasStatesContract;

class Vehicle extends Model implements HasStatesContract
{
    use SoftDeletes;
    use HasStates;
    use HasStateHistory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'vin',
        // 'code',
        'model_id',
        'maintenance_group_id',
        'state',
        'construction_year',
        'warranty_initial_date',
        'warranty_months',
        'warranty_initial_km',
        'warranty_km',
        'commissioning_date',
        'is_historic',
    ];

    public function __construct(array $attributes = [])
    {
        // Dynamically resolve state class from config (falls back to default)
        $this->casts['warranty_initial_date'] = 'date';
        $this->casts['state'] = config(
            'pkg-fleet.classes.vehicle_state_class',
            VehicleState::class // package default
        );

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('pkg-fleet.table_prefix') . 'vehicles';
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, "model_id");
    }

    public function maintenanceGroup(): BelongsTo
    {
        return $this->belongsTo(MaintenanceGroup::class, "maintenance_group_id");
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
            config('pkg-fleet.table_prefix') . "vehicle_code_history",
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
        if ($this->relationLoaded('codes')) {
            return $this->codes
                ->filter(fn($c) => $c->pivot->date_to === null)
                ->sortByDesc(fn($c) => $c->pivot->date_from)
                ->first();
        }

        return $this->codes()
            ->wherePivot('date_to', null)
            ->orderByDesc('date_from')
            ->first();
    }

    public function getLicencePlateAttribute()
    {
        return $this->code?->code ?? $this->licencePlates()->first()?->code ?? 'N/A';
    }

    public function getLabelAttribute(): ?string
    {
        return $this->code?->code ?? $this->licencePlates()->first()?->code ?? 'N/A';
    }

    public function getLabelWithModelAttribute(): ?string
    {
        return $this->getLabelAttribute() . ',     ' . $this->model?->title;
    }

    // TO DO
    public function isUnderWarranty(): bool
    {
        return true;
    }

    public function travelLog(): HasMany
    {
        return $this->hasMany(TravelLog::class, 'vehicle_id');
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

        $query->whereHas('model', function ($q) use ($type) {
            $q->byType($type);
        });
    }

    public function scopeByTypeIds(Builder $query, array $typeIds)
    {
        $query->whereHas('model.type', function ($q) use ($typeIds) {
            $q->byIds($typeIds);
        });
    }

    public function scopeByModelIds(Builder $query, array $modelIds)
    {
        $query->whereIn('model_id', $modelIds);
    }

    /**
     * Summary of scopeByBrand
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $brand
     * @return void
     */
    public function scopeByBrand(Builder $query, string|array $brand)
    {
        // cast input to array
        $brand = is_array($brand) ? $brand : [$brand];

        $query->whereHas('model', function ($q) use ($brand) {
            $q->byBrand($brand);
        });
    }

    /**
     * Summary of scopeByMaintenanceGroup
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $maintenanceGroup
     * @return void
     */
    public function scopeByMaintenanceGroup(Builder $query, string|array $maintenanceGroup)
    {
        // cast input to array
        $maintenanceGroup = is_array($maintenanceGroup) ? $maintenanceGroup : [$maintenanceGroup];

        $query->whereHas('maintenanceGroup', function ($q) use ($maintenanceGroup) {
            $q->byCode($maintenanceGroup);
        });
    }

    /**
     * Summary of scopeByMaintenanceGroup
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $maintenanceGroup
     * @return void
     */
    public function scopeByMaintenanceGroupId(Builder $query, int|array $maintenanceGroupIds)
    {
        // cast input to array
        $maintenanceGroupIds = Arr::wrap($maintenanceGroupIds);

        $query->whereIn('maintenance_group_id', $maintenanceGroupIds);
    }

    /**
     * Summary of scopeByGroup
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $group
     * @return void
     */
    public function scopeByGroup(Builder $query, string|array $group)
    {
        // cast input to array
        $group = is_array($group) ? $group : [$group];

        $query->whereHas('groups', function ($q) use ($group) {
            $q->byCode($group);
        });
    }    
}
