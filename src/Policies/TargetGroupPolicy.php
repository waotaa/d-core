<?php

namespace Vng\DennisCore\Policies;

use Vng\DennisCore\Interfaces\IsManagerInterface;

class TargetGroupPolicy extends InstrumentPropertyPolicy
{
    public function viewAny(IsManagerInterface $user)
    {
        return $this->can($user, 'targetGroup.viewAny');
    }

    public function view(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroup.view');
    }

    public function create(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroup.create');
    }

    public function update(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroup.update');
    }

    public function delete(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroup.delete');
    }

    public function restore(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroup.restore');
    }

    public function forceDelete(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroup.forceDelete');
    }
}
