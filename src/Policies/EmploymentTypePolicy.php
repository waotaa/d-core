<?php

namespace Vng\DennisCore\Policies;

use Vng\DennisCore\Interfaces\IsManagerInterface;

class EmploymentTypePolicy extends InstrumentPropertyPolicy
{
    public function viewAny(IsManagerInterface $user)
    {
        return $this->can($user, 'employmentType.viewAny');
    }

    public function view(IsManagerInterface $user)
    {
        return $user->managerCan('employmentType.view');
    }

    public function create(IsManagerInterface $user)
    {
        return $user->managerCan('employmentType.create');
    }

    public function update(IsManagerInterface $user)
    {
        return $user->managerCan('employmentType.update');
    }

    public function delete(IsManagerInterface $user)
    {
        return $user->managerCan('employmentType.delete');
    }

    public function restore(IsManagerInterface $user)
    {
        return $user->managerCan('employmentType.restore');
    }

    public function forceDelete(IsManagerInterface $user)
    {
        return $user->managerCan('employmentType.forceDelete');
    }
}
