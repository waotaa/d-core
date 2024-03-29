<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Models\Role;
use Vng\DennisCore\Repositories\ManagerRepositoryInterface;
use Vng\DennisCore\Repositories\OrganisationRepositoryInterface;

class ManagerRepository extends BaseRepository implements ManagerRepositoryInterface
{
    public string $model = Manager::class;

    public function addMultipleOrganisationConditions(Builder $query, Collection $organisations): Builder
    {
        $query->where(function(Builder $query) use ($organisations) {
            $organisations->each(function (Organisation $organisation) use (&$query) {
                $query->orWhere(function(Builder $query) use ($organisation) {
                    return $this->addOrganisationCondition($query, $organisation);
                });
            });
        });
        return $query;
    }

    public function addOrganisationCondition(Builder $query, Organisation $organisation): Builder
    {
        return $query->whereHas('organisations', function (Builder $query) use ($organisation) {
            $query->where('id', $organisation->id);
        });
    }

    /**
     * @param IsManagerInterface&DennisUserInterface&Model $user
     * @return Manager
     */
    public function createForUser(IsManagerInterface $user): Manager
    {
        /** @var Manager $manager */
        $manager = $this->new();
        $manager->fill([
            'givenName' => $user->getGivenName(),
            'surName' => $user->getSurName(),
            'email' => $user->getEmail(),
        ]);
        $manager->save();

        $user->manager()->associate($manager);
        $user->save();
        return $manager;
    }

    public function update(Manager $manager, $attributes): Manager
    {
        $manager->fill([
            'givenName' => $attributes['givenName'],
            'surName' => $attributes['surName'],
            'months_unupdated_limit' => $attributes['months_unupdated_limit'],
        ]);

        $manager->save();
        return $manager;
    }

    public function attachOrganisations(Manager $manager, string|array $organisationIds): Manager
    {
        $organisationIds = (array) $organisationIds;

        /** @var OrganisationRepositoryInterface $organisationRepo */
        $organisationRepo = app(OrganisationRepositoryInterface::class);
        $organisations = $organisationRepo->builder()->whereIn('id', $organisationIds)->get();
        $organisations->each(fn (Organisation $org) => Gate::authorize('attachOrganisation', [$manager, $org]));

        $manager->organisations()->syncWithoutDetaching($organisationIds);
        return $manager;
    }

    public function detachOrganisations(Manager $manager, string|array $organisationIds): Manager
    {
        $organisationIds = (array) $organisationIds;

        /** @var OrganisationRepositoryInterface $organisationRepo */
        $organisationRepo = app(OrganisationRepositoryInterface::class);
        $organisations = $organisationRepo->builder()->whereIn('id', $organisationIds)->get();
        $organisations->each(fn (Organisation $org) => Gate::authorize('detachOrganisation', [$manager, $org]));

        $manager->organisations()->detach($organisationIds);
        return $manager;
    }

    public function attachRole(Manager $manager, Role $role): Manager
    {
        Gate::authorize('attachRole', [$manager, $role]);

        $manager->assignRole($role);
        return $manager;
    }

    public function detachRole(Manager $manager, Role $role): Manager
    {
        Gate::authorize('detachRole', [$manager, $role]);

        $manager->removeRole($role);
        return $manager;
    }
}
