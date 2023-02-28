<?php

namespace Vng\DennisCore\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Organisation;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function addMultipleSameAssociationCondition(Builder $query, Collection $organisations): Builder;
    public function addSameOrganisationCondition(Builder $query, Organisation $organisation): Builder;
    public function addViewAllCondition(Builder $query): Builder;
    public function addViewSelfCondition(Builder $query, DennisUserInterface $user): Builder;
    public function addViewCreatedByCondition(Builder $query, IsManagerInterface $isManager): Builder;
}
