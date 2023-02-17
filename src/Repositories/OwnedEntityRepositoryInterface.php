<?php

namespace Vng\DennisCore\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Organisation;

interface OwnedEntityRepositoryInterface extends BaseRepositoryInterface
{
    public function addOwnerlessCondition(Builder $query): Builder;

    public function addMultipleOwnerConditions(Builder $query, Collection $organisations): Builder;

    public function addOrganisationCondition(Builder $query, Organisation $organisation): Builder;

    public function addForUserConditions(Builder $query, IsManagerInterface $user): Builder;

    public function getQueryItemsManagedByUser(IsManagerInterface $user): Builder;
}
