<?php

namespace Vng\DennisCore\Policies;

use Vng\DennisCore\Interfaces\IsManagerInterface;

class SectorPolicy extends InstrumentPropertyPolicy
{
    public function viewAny(IsManagerInterface $user)
    {
        return $this->can($user, 'sector.viewAny');
    }

    public function view(IsManagerInterface $user)
    {
        return $user->managerCan('sector.view');
    }

    public function create(IsManagerInterface $user)
    {
        return $user->managerCan('sector.create');
    }

    public function update(IsManagerInterface $user)
    {
        return $user->managerCan('sector.update');
    }

    public function delete(IsManagerInterface $user)
    {
        return $user->managerCan('sector.delete');
    }

    public function restore(IsManagerInterface $user)
    {
        return $user->managerCan('sector.restore');
    }

    public function forceDelete(IsManagerInterface $user)
    {
        return $user->managerCan('sector.forceDelete');
    }
}
