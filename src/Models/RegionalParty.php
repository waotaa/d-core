<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Vng\DennisCore\ElasticResources\RegionalPartyResource;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Traits\AreaTrait;

class RegionalParty extends AbstractOrganisationBase implements AreaInterface
{
    use HasFactory, AreaTrait;

    protected $table = 'regional_parties';

    protected string $elasticResource = RegionalPartyResource::class;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function getParentAreas(): ?Collection
    {
        return $this->region->getParentAreas();
    }

    public function getOwnAreas(): Collection
    {
        return $this->region->getOwnAreas();
    }

    public function getChildAreas(): ?Collection
    {
        return $this->region->getChildAreas();
    }
}

