<?php

namespace Vng\DennisCore\Models;

use Database\Factories\InstrumentFactory;
use Illuminate\Database\Eloquent\Builder;
use Vng\DennisCore\Casts\CleanedHtml;
use Vng\DennisCore\ElasticResources\InstrumentResource;
use Vng\DennisCore\Enums\DurationUnitEnum;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Interfaces\IsMemberInterface;
use Vng\DennisCore\Observers\InstrumentObserver;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Services\AreaService;
use Vng\DennisCore\Traits\CanSaveQuietly;
use Vng\DennisCore\Traits\HasContacts;
use Vng\DennisCore\Traits\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Vng\DennisCore\Traits\ModelSearch;
use Webpatser\Uuid\Uuid;

class Instrument extends SearchableModel
{
    use SoftDeletes,
        CanSaveQuietly,
        HasContacts,
        HasFactory,
        HasOwner,
        ModelSearch,
        MutationLog;

    const REACH_LOCAL = 'local';
    const REACH_REGIONAL = 'regional';
    const REACH_NATIONAL = 'national';

    protected $table = 'instruments';
    protected string $elasticResource = InstrumentResource::class;
    protected $fillable = [
        'created_at',
        'updated_at',

        'uuid',
        'name',

        'is_active',
        'is_temporary',
        'is_leerwerktraject',

        'publish_from',
        'publish_to',

        // descriptions
        'short_description',
        'description',
        'applications',
        'conditions',

        // auxilary
        'import_mark',
    ];

    protected $dates = [
        'publish_from',
        'publish_to'
    ];

    protected $attributes = [
        'is_active' => true,
        'is_temporary' => false,
        'is_leerwerktraject' => false,
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_temporary' => 'boolean',
        'is_leerwerktraject' => 'boolean',

        'short_description' => CleanedHtml::class,
        'description' => CleanedHtml::class,
        'applications' => CleanedHtml::class,
        'conditions' => CleanedHtml::class,
    ];

    protected $with = [];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });

        self::deleted(function ($model) {
            $model->is_active = false;
        });

        static::observe(InstrumentObserver::class);
    }

    protected static function newFactory(): InstrumentFactory
    {
        return InstrumentFactory::new();
    }

    public function getSearchId()
    {
        return $this->uuid;
    }

    public function availableRegions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class, 'available_region_instrument')
            ->withTimestamps()
            ->using(AvailableRegionInstrument::class);
    }

    public function availableTownships(): BelongsToMany
    {
        return $this->belongsToMany(Township::class, 'available_township_instrument')
            ->withTimestamps()
            ->using(AvailableTownshipInstrument::class);
    }

    public function availableNeighbourhoods(): BelongsToMany
    {
        return $this->belongsToMany(Neighbourhood::class, 'available_neighbourhood_instrument')
            ->withTimestamps()
            ->using(AvailableNeighbourhoodInstrument::class);
    }

    /**
     * Returns the exact ereas (no sub-areas) the instrument is available in when the availablity is
     * overridden throught the availableRegions, -Townships, or -Neighbourhoods properties
     *
     * @return Collection|null
     */
    public function getSpecifiedAvailableAreasAttribute(): ?Collection
    {
        $areas = collect([]);

        if ($this->availableRegions()->count() > 0) {
            $this->availableRegions()->each(function (Region $region) use ($areas) {
                $areas->add($region);
            });
        }

        if ($this->availableTownships()->count() > 0) {
            $this->availableTownships()->each(function (Township $township) use ($areas) {
                $areas->add($township);
                AreaService::removeAreaFromCollection($areas, $township->region);
            });
        }

        if ($this->availableNeighbourhoods()->count() > 0) {
            $this->availableNeighbourhoods()->each(function (Neighbourhood $neighbourhood) use ($areas) {
                $areas->add($neighbourhood);
                AreaService::removeAreaFromCollection($areas, $neighbourhood->township);
            });
        }

        return !$areas->isEmpty() ? $areas->values() : null;
    }

    /**
     * Returns the exact ereas (no sub-areas) the instrument is available in
     * either based on the specified availablity or based on the owner of the instrument
     *
     * @return Collection|null
     */
    public function getAvailableAreasAttribute(): Collection
    {
        if (!is_null($this->specifiedAvailableAreas)) {
            return $this->specifiedAvailableAreas;
        }

        if (is_null($this->organisation)) {
            return AreaService::getNationalAreas();
        }

        // Has owner: Return owner areas
        /** @var AreaInterface $organisationEntity */
        $organisationEntity = $this->organisation->organisationable;
        return $organisationEntity->getOwnAreas();
    }

    /**
     * Returns all (encompassing) areas the instrument is available in.
     * Includes all townships of an available region
     * Includes the region of an available township
     *
     * @return Collection
     */
    public function getAllAvailableAreasAttribute(): Collection
    {
        return AreaService::getEncompassingAreasForCollection($this->availableAreas);
    }

    /**
     * Checks if every region is available in the available areas
     *
     * @return bool
     */
    public function isNational(): bool
    {
        $nationalAreaIdentifiers = AreaService::getNationalAreas()->map(fn (AreaInterface $area) => $area->getAreaIdentifier());
        $availableAreaIdentifiers = $this->availableAreas->map(fn (AreaInterface $area) => $area->getAreaIdentifier());
        $regionsNotInAvailableAreas = $nationalAreaIdentifiers->diff($availableAreaIdentifiers);
        return $regionsNotInAvailableAreas->count() === 0;
    }

    public function isRegional(): bool
    {
        if ($this->isNational()) {
            return false;
        }
        $regionAreas = $this->availableAreas->filter(function (AreaInterface $area) {
            return $area->getType() === 'Region';
        });
        return $regionAreas->count() > 0;
    }

    public function isLocal(): bool
    {
        return !$this->isNational() && !$this->isRegional();
    }

    public function getReach()
    {
        if ($this->isLocal()) {
            return static::REACH_LOCAL;
        }
        if ($this->isRegional()) {
            return static::REACH_REGIONAL;
        }
        return static::REACH_NATIONAL;
    }

    public function instrumentType(): BelongsTo
    {
        return $this->belongsTo(InstrumentType::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function registrationCodes(): HasMany
    {
        return $this->hasMany(RegistrationCode::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function ageGroups(): BelongsToMany
    {
        return $this->belongsToMany(AgeGroup::class, 'age_group_instrument')
            ->withTimestamps()
            ->using(AgeGroupInstrument::class);
    }

    public function employmentTypes(): BelongsToMany
    {
        return $this->belongsToMany(EmploymentType::class, 'employment_type_instrument')
            ->withTimestamps()
            ->using(EmploymentTypeInstrument::class);
    }

    public function sectors(): BelongsToMany
    {
        return $this->belongsToMany(Sector::class, 'instrument_sector')
            ->withTimestamps()
            ->using(InstrumentSector::class);
    }

    public function targetGroupRegisters(): BelongsToMany
    {
        return $this->belongsToMany(TargetGroupRegister::class, 'instrument_target_group_register')
            ->withTimestamps()
            ->using(InstrumentTargetGroupRegister::class);
    }

    public function targetGroups(): BelongsToMany
    {
        return $this->belongsToMany(TargetGroup::class, 'instrument_target_group')
            ->withTimestamps()
            ->using(InstrumentTargetGroup::class);
    }

    public function tiles(): BelongsToMany
    {
        return $this->belongsToMany(Tile::class, 'instrument_tile')
            ->withTimestamps()
            ->using(InstrumentTile::class);
    }

    // Content
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    public function instrumentTrackers(): HasMany
    {
        return $this->hasMany(InstrumentTracker::class);
    }

    public function watchingUsers()
    {
        return $this->belongsToMany(Manager::class, 'instrument_trackers')->using(InstrumentTracker::class);
    }


    public function scopeOwnedBy(Builder $query, IsMemberInterface $user)
    {
        $instrumentRepository = $this->app->make(InstrumentRepositoryInterface::class);
        return $instrumentRepository->addMultipleOwnerConditions($query, $user->getAssociations());
    }
}
