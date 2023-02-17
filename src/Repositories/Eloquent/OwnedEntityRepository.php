<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Organisation;

trait OwnedEntityRepository
{
    public function addOwnerlessCondition(Builder $query): Builder
    {
        return $query->whereNull('owner_id');
    }

    public function addMultipleOwnerConditions(Builder $query, Collection $organisations): Builder
    {
        $organisations->each(function (Organisation $organisation) use (&$query) {
            $query->orWhere(function($query) use ($organisation) {
                return $this->addOrganisationCondition($query, $organisation);
            });
        });
        return $query;
    }

    public function addOrganisationCondition(Builder $query, Organisation $organisation): Builder
    {
        return $query->where('organisation_id', $organisation->id);
    }

    /**
     * @param Builder $query
     * @param IsManagerInterface&Authorizable $user
     * @return Builder
     */
    public function addForUserConditions(Builder $query, IsManagerInterface $user): Builder
    {
        if (!$user->can('viewAll', $this->model)) {
            $query = $query->whereNull('organisation_id');
            $query = $this->addMultipleOwnerConditions($query, $user->getManager()->organisations);
        }

        return $query;
    }

    public function getQueryItemsManagedByUser(IsManagerInterface $user): Builder
    {
        return $this->addForUserConditions($this->builder(), $user);
    }
}
