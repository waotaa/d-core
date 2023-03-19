<?php

namespace Vng\DennisCore\Models;

use Database\Factories\LocalPartyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Vng\DennisCore\ElasticResources\LocalPartyResource;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Traits\AreaTrait;

class LocalParty extends AbstractOrganisationBase implements AreaInterface
{
    use HasFactory, AreaTrait;

    protected $table = 'local_parties';

    protected string $elasticResource = LocalPartyResource::class;

    protected $fillable = [
        'name',
        'slug',
    ];
    
    protected static function newFactory(): LocalPartyFactory
    {
        return LocalPartyFactory::new();
    }

    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class);
    }

    public function getParentAreas(): ?Collection
    {
        return $this->township->getParentAreas();
    }

    public function getOwnAreas(): Collection
    {
        return $this->township->getOwnAreas();
    }

    public function getChildAreas(): ?Collection
    {
        return $this->township->getChildAreas();
    }
}

