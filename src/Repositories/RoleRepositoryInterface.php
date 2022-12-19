<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Role;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function attachManager(Role $role, Manager $manager): Role;
    public function detachManager(Role $role, Manager $manager): Role;
}
