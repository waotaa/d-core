<?php

namespace Vng\DennisCore\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Observers\OrganisationEntityObserver;

trait OrganisationEntity
{
    protected static function bootOrganisationEntity()
    {
        static::observe(OrganisationEntityObserver::class);
    }

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function delete()
    {
        $this->organisation->delete();
        parent::delete();
    }
}
