<?php

namespace Vng\DennisCore\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Interfaces\IsOwnerInterface;

interface OwnedEntityRepositoryInterface extends BaseRepositoryInterface
{
    public function addOwnerlessCondition(Builder $query): Builder;

    public function addMultipleOwnerConditions(Builder $query, Collection $associations): Builder;

    public function addOwnerCondition(Builder $query, IsOwnerInterface $owner): Builder;

    public function addForUserConditions(Builder $query, DennisUserInterface $user);
}
