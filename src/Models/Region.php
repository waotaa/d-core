<?php

namespace Vng\DennisCore\Models;

use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Interfaces\IsOwnerInterface;
use Vng\DennisCore\ElasticResources\RegionResource;
use Vng\DennisCore\Traits\AreaTrait;
use Vng\DennisCore\Traits\HasContacts;
use Vng\DennisCore\Traits\HasDynamicSlug;
use Vng\DennisCore\Traits\IsOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Region extends SearchableModel implements IsOwnerInterface, AreaInterface
{
    use HasFactory, SoftDeletes, HasDynamicSlug, IsOwner, HasContacts, AreaTrait;

    protected $table = 'regions';
    protected string $elasticResource = RegionResource::class;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'color',
        'description',
        'cooperation_partners',
    ];

    // A Region has many gemeenten
    public function townships(): HasMany
    {
        return $this->hasMany(Township::class);
    }

    public function regionalParties(): HasMany
    {
        return $this->hasMany(RegionalParty::class);
    }

    public function getParentAreas(): ?Collection
    {
        return null;
    }

    public function getChildAreas(): ?Collection
    {
        return $this->townships;
    }
}
