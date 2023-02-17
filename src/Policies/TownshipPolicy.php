<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Partnership;
use Vng\DennisCore\Models\Township;

class TownshipPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user): bool
    {
        return $user->managerCan('township.viewAny');
    }

    public function view(IsManagerInterface $user, Township $township): bool
    {
        return $user->managerCan('township.view');
    }

    public function create(IsManagerInterface $user): bool
    {
        return false;
    }

    public function update(IsManagerInterface $user, Township $township): bool
    {
        return $user->managerCan('township.update');
    }

    public function delete(IsManagerInterface $user, Township $township): bool
    {
        return false;
    }

    public function restore(IsManagerInterface $user, Township $township): bool
    {
        return $user->managerCan('township.restore');
    }

    public function forceDelete(IsManagerInterface $user, Township $township): bool
    {
        return false;
    }

    public function attachAnyPartnership(Authorizable $user, Township $township): bool
    {
        return $user->can('create', Partnership::class);
    }
    public function attachPartnership(Authorizable $user, Township $township, Partnership $partnership,): bool
    {
        return $user->can('attachAnyPartnership', $township);
    }
    public function detachPartnership(Authorizable $user, Township $township, Partnership $partnership): bool
    {
        return $user->can('attachAnyPartnership', $township);
    }
}
