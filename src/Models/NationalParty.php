<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Vng\DennisCore\ElasticResources\NationalPartyResource;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Services\AreaService;
use Vng\DennisCore\Traits\AreaTrait;

class NationalParty extends AbstractOrganisationBase implements AreaInterface
{
    use HasFactory, AreaTrait;

    protected $table = 'national_parties';

    protected string $elasticResource = NationalPartyResource::class;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getParentAreas(): ?Collection
    {
        return null;
    }

    public function getOwnAreas(): Collection
    {
        return AreaService::getNationalAreas();
    }

    public function getChildAreas(): ?Collection
    {
        return $this->getOwnAreas()
            ->map(fn (AreaInterface $area) => $area->getChildAreas())
            ->flatten()
            ->unique(fn (AreaInterface $area) => $area->getAreaIdentifier());
    }
}

