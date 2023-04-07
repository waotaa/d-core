<?php

namespace Vng\DennisCore\Models;

use Database\Factories\PartnershipFactory;
use Vng\DennisCore\ElasticResources\PartnershipResource;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Traits\AreaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Partnership extends AbstractOrganisationBase implements AreaInterface
{
    use HasFactory, AreaTrait;

    protected string $elasticResource = PartnershipResource::class;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function newFactory()
    {
        return PartnershipFactory::new();
    }

    public function townships(): BelongsToMany
    {
        return $this->belongsToMany(Township::class);
    }

    public function getOwnAreas(): Collection
    {
        $areaCollection = collect();

        // The areas of it's townships
        if ($this->townships) {
            foreach ($this->townships as $township) {
                $areaCollection = $areaCollection->concat($township->getOwnAreas());
            }
        }

        return $areaCollection->unique();
    }

    public function getParentAreas(): ?Collection
    {
        return $this->townships
            ->map(fn (Township $township) => $township->region)
            ->unique('id');
    }

    public function getChildAreas(): ?Collection
    {
        return $this->getOwnAreas()
            ->map(fn (AreaInterface $area) => $area->getChildAreas())
            ->flatten()
            ->unique(fn (AreaInterface $area) => $area->getAreaIdentifier());
    }
}
