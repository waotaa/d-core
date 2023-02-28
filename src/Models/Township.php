<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Vng\DennisCore\ElasticResources\TownshipResource;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Interfaces\IsOwnerInterface;
use Vng\DennisCore\Traits\AreaTrait;
use Vng\DennisCore\Traits\HasDynamicSlug;
use Vng\DennisCore\Traits\IsOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Township extends SearchableModel implements IsOwnerInterface, AreaInterface
{
    use HasFactory, SoftDeletes, HasDynamicSlug, IsOwner, AreaTrait;

    protected $table = 'townships';
    protected string $elasticResource = TownshipResource::class;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'region_code',
        'description'
    ];

    // A Township belongs to a Region
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    // A Township can have many parts
    public function neighbourhoods(): HasMany
    {
        return $this->hasMany(Neighbourhood::class);
    }

    public function getParentAreas(): ?Collection
    {
        return collect([$this->region]);
    }

    public function getChildAreas(): ?Collection
    {
        return $this->neighbourhoods;
    }

    public function localParties(): HasMany
    {
        return $this->hasMany(LocalParty::class);
    }

    public function partnerships(): BelongsToMany
    {
        return $this->belongsToMany(Partnership::class);
    }
}
