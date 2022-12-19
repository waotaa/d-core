<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Traits\AreaTrait;

class Neighbourhood extends Model implements AreaInterface
{
    use AreaTrait;

    protected $table = 'neighbourhoods';

    protected $fillable = [
        'name',
    ];

    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class);
    }

    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'available_neighbourhood_instrument')
            ->withTimestamps()
            ->using(AvailableNeighbourhoodInstrument::class);
    }

    public function getParentAreas(): ?Collection
    {
        return collect([$this->township]);
    }

    public function getChildAreas(): ?Collection
    {
        return null;
    }
}
