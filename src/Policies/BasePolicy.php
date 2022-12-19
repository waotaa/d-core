<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Manager;

abstract class BasePolicy
{
    use HandlesAuthorization;

    public function can(IsManagerInterface $user, $permission)
    {
        return $user->managerCan($permission);
    }

    public function before(IsManagerInterface $user)
    {
        if ($this->getManager($user)->isSuperAdmin()) {
            return true;
        }
        return null;
    }

    protected function getManager(IsManagerInterface $user): Manager
    {
        $manager = $user->getManager();
        if (is_null($manager)) {
            throw new \Exception('No manager found on user');
        }
        return $manager;
    }
}