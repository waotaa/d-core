<?php

namespace Vng\DennisCore\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Role;

interface ManagerRepositoryInterface extends BaseRepositoryInterface
{
    public function addMultipleOrganisationConditions(Builder $query, Collection $organisations): Builder;
    public function addOrganisationCondition(Builder $query, Organisation $organisation): Builder;

    public function createForUser(IsManagerInterface $user): Manager;
    public function update(Manager $manager, array $attributes): Manager;

    public function attachOrganisations(Manager $manager, string|array $organisationIds): Manager;
    public function detachOrganisations(Manager $manager, string|array $organisationIds): Manager;

    public function attachRole(Manager $manager, Role $role): Manager;
    public function detachRole(Manager $manager, Role $role): Manager;
}
