<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\LocalParty;

class LocalPartyPolicy extends BaseOrganisationPolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user)
    {
        return $user->managerCan('localParty.viewAny');
    }

    public function view(IsManagerInterface $user, LocalParty $localParty)
    {
        if($localParty->hasMember($user->getManager())){
            return true;
        }
        return $user->managerCan('localParty.view');
    }

    public function create(IsManagerInterface $user)
    {
        return $user->managerCan('localParty.create');
    }

    public function update(IsManagerInterface $user, LocalParty $localParty)
    {
        if($localParty->hasMember($user->getManager())
            && $user->managerCan('organisation.update')) {
            return true;
        }
        return $user->managerCan('localParty.update');
    }

    public function delete(IsManagerInterface $user, LocalParty $localParty)
    {
        if($localParty->hasMember($user->getManager())
            && $user->managerCan('organisation.delete')) {
            return true;
        }
        return $user->managerCan('localParty.delete');
    }

    public function restore(IsManagerInterface $user, LocalParty $localParty)
    {
        if (!$localParty->trashed()) {
            return false;
        }
        if($localParty->hasMember($user->getManager())
            && $user->managerCan('organisation.restore')) {
            return true;
        }
        return $user->managerCan('localParty.restore');
    }

    public function forceDelete(IsManagerInterface $user, LocalParty $localParty)
    {
        if (!$localParty->trashed()) {
            return false;
        }
        if($localParty->hasMember($user->getManager())
            && $user->managerCan('organisation.forceDelete')) {
            return true;
        }
        return $user->managerCan('localParty.forceDelete');
    }
}
