<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Remove after fully migrated to Orchid
 * Associatables are a pivot between users and an owner (morph relation)
 * This pivot is replaced by the relation between managers and organisation
 *
 * @deprecated
 */
abstract class Associateable extends MorphPivot
{
    public $incrementing = true;
    protected $table = 'associateables';

    abstract public function user(): BelongsTo;

    public function association(): MorphTo
    {
        return $this->morphTo('associateable');
    }

    public function getAssociationNameAttribute()
    {
        return $this->association->name;
    }

    public function getAssociationTypeAttribute(): ?string
    {
        if (is_null($this->association)) {
            return null;
        }
        return $this->association->getOwnerType();
    }
}
