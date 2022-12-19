<?php

namespace Vng\DennisCore\Traits;

use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Provider;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use ReflectionClass;

trait IsOwner
{
    public function getOwnerClass(): string
    {
        return get_class($this);
    }

    public function getOwnerId()
    {
        return $this->id;
    }

    public function getOwnerType(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function ownedInstruments(): MorphMany
    {
        return $this->morphMany(Instrument::class, 'owner');
    }

    public function ownsInstrument(Instrument $instrument): bool
    {
        return $this->ownedInstruments->contains($instrument->id);
    }

    public function ownedProviders(): MorphMany
    {
        return $this->morphMany(Provider::class, 'owner');
    }

    public function ownedItemsCount(): int
    {
        $instrumentCount = $this->ownedInstruments()->count();
        $providerCount = $this->ownedProviders()->count();
        return $instrumentCount + $providerCount;
    }
}
