<?php

namespace Vng\DennisCore\Policies;

use Vng\DennisCore\Interfaces\IsManagerInterface;

class TargetGroupRegisterPolicy extends InstrumentPropertyPolicy
{
    public function viewAny(IsManagerInterface $user)
    {
        return $this->can($user, 'targetGroupRegister.viewAny');
    }

    public function view(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroupRegister.view');
    }

    public function create(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroupRegister.create');
    }

    public function update(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroupRegister.update');
    }

    public function delete(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroupRegister.delete');
    }

    public function restore(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroupRegister.restore');
    }

    public function forceDelete(IsManagerInterface $user)
    {
        return $user->managerCan('targetGroupRegister.forceDelete');
    }
}
