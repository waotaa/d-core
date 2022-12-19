<?php

namespace Vng\DennisCore\Policies;

use Vng\DennisCore\Interfaces\IsManagerInterface;

class AgeGroupPolicy extends InstrumentPropertyPolicy
{
    public function viewAny(IsManagerInterface $user)
    {
        return $this->can($user, 'ageGroup.viewAny');
    }

    public function view(IsManagerInterface $user)
    {
        return $user->managerCan('ageGroup.view');
    }

    public function create(IsManagerInterface $user)
    {
        return $user->managerCan('ageGroup.create');
    }

    public function update(IsManagerInterface $user)
    {
        return $user->managerCan('ageGroup.update');
    }

    public function delete(IsManagerInterface $user)
    {
        return $user->managerCan('ageGroup.delete');
    }

    public function restore(IsManagerInterface $user)
    {
        return $user->managerCan('ageGroup.restore');
    }

    public function forceDelete(IsManagerInterface $user)
    {
        return $user->managerCan('ageGroup.forceDelete');
    }
}
