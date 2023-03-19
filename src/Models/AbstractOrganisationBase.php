<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use ReflectionClass;
use Vng\DennisCore\Interfaces\OrganisationEntityInterface;
use Vng\DennisCore\Observers\OrganisationEntityObserver;
use Vng\DennisCore\Traits\HasDynamicSlug;

abstract class AbstractOrganisationBase extends SearchableModel implements OrganisationEntityInterface
{
    use SoftDeletes {
        SoftDeletes::restore as softDeleteRestore;
        SoftDeletes::forceDelete as softDeleteForceDelete;
    }
    use HasDynamicSlug;

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

    public function hasMember(Model $user): bool
    {
        return $this->organisation->hasMember($user->getManager());
    }

    public function delete()
    {
        $this->organisation->delete();
        parent::delete();
    }

    public function restore()
    {
        $this->organisation->restore();
        $this->softDeleteRestore();
    }

    public function forceDelete()
    {
        $this->organisation->forceDelete();
        $this->softDeleteForceDelete();
    }
}

