<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Interfaces\IsOwnerInterface;
use Vng\DennisCore\Models\Instrument;

trait OwnedEntityRepository
{
    public function addOwnerlessCondition(Builder $query): Builder
    {
        return $query->whereNull('owner_id');
    }

    public function addMultipleOwnerConditions(Builder $query, Collection $associations): Builder
    {
        $associations->each(function (IsOwnerInterface $owner) use (&$query) {
            $query->orWhere(function($query) use ($owner) {
                return $this->addOwnerCondition($query, $owner);
            });
        });
        return $query;
    }

    public function addOwnerCondition(Builder $query, IsOwnerInterface $owner): Builder
    {
        return $query
            ->where('owner_type', $owner->getOwnerClass())
            ->where('owner_id', $owner->getOwnerId());
    }

    public function addForUserConditions(Builder $query, DennisUserInterface $user)
    {

        if (!$user->can('viewAll', Instrument::class)) {
            $query = $this->addMultipleOwnerConditions($query, $user->getAssociations());
        }

        return $query;
    }
}
