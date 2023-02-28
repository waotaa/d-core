<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Vng\DennisCore\Interfaces\IsManagerInterface;

class TilePolicy extends InstrumentPropertyPolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user)
    {
        return $this->can($user, 'tile.viewAny');
    }

    public function view(IsManagerInterface $user)
    {
        return $user->managerCan('tile.view');
    }

    public function create(IsManagerInterface $user)
    {
        return $user->managerCan('tile.create');
    }

    public function update(IsManagerInterface $user)
    {
        return $user->managerCan('tile.update');
    }

    public function delete(IsManagerInterface $user)
    {
        return $user->managerCan('tile.delete');
    }

    public function restore(IsManagerInterface $user)
    {
        return $user->managerCan('tile.restore');
    }

    public function forceDelete(IsManagerInterface $user)
    {
        return $user->managerCan('tile.forceDelete');
    }
}
