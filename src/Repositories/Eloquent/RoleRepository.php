<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Role;
use Vng\DennisCore\Repositories\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public string $model = Role::class;

    public function attachManager(Role $role, Manager $manager): Role
    {
        $manager->assignRole($role);
        return $role;
    }

    public function detachManager(Role $role, Manager $manager): Role
    {
        $manager->removeRole($role);
        return $role;
    }
}
