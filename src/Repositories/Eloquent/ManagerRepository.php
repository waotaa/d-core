<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Http\Requests\ManagerUpdateRequest;
use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Models\Role;
use Vng\DennisCore\Repositories\ManagerRepositoryInterface;

class ManagerRepository extends BaseRepository implements ManagerRepositoryInterface
{
    public string $model = Manager::class;

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
        $manager->organisations()->syncWithoutDetaching($organisationIds);
        return $manager;
    }

    public function detachOrganisations(Manager $manager, string|array $organisationIds): Manager
    {
        $manager->organisations()->detach($organisationIds);
        return $manager;
    }

    public function attachRole(Manager $manager, Role $role): Manager
    {
        $manager->assignRole($role);
        return $manager;
    }

    public function detachRole(Manager $manager, Role $role): Manager
    {
        $manager->removeRole($role);
        return $manager;
    }
}
