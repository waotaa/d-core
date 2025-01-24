<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use ReflectionClass;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Interfaces\OrganisationEntityInterface;
use Vng\DennisCore\Observers\OrganisationEntityObserver;
use Vng\DennisCore\Traits\HasDynamicSlug;

abstract class AbstractOrganisationBase extends SearchableModel implements OrganisationEntityInterface
{
    use SoftDeletes;
    use HasDynamicSlug;

    public bool $isCascadingDelete = false;
    public bool $isCascadingRestore = false;

    protected static function boot()
    {
        parent::boot();
        static::observe(OrganisationEntityObserver::class);
    }

    public function getTypeAttribute(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function hasMember(Model|IsManagerInterface $manager): bool
    {
        if ($manager instanceof IsManagerInterface) {
            $manager = $manager->getManager();
        }
        return $this->organisation->hasMember($manager);
    }
}

