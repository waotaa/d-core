<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\RegionalParty;
use Vng\DennisCore\Models\RegionPage;

class RegionPagePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user): bool
    {
        return $user->managerCan('regionPage.viewAny');
    }

    public function view(Authorizable&IsManagerInterface $user, RegionPage $regionPage): bool
    {
        /** @var RegionalParty|null $regionalParty */
        $regionalParty = $regionPage->regionalParty;
        if (!is_null($regionalParty) && $regionalParty->hasMember($user)) {
            // When you are a member of the regional party that manages the region page, you may view it
            return true;
        }

        return $user->managerCan('regionPage.view');
    }

    public function create(IsManagerInterface $user): bool
    {
        return $user->managerCan('regionPage.create');
    }

    public function update(Authorizable&IsManagerInterface $user, RegionPage $regionPage): bool
    {
        /** @var RegionalParty|null $regionalParty */
        $regionalParty = $regionPage->regionalParty;
        if (
            !is_null($regionalParty) &&
            $regionalParty->hasMember($user) &&
            $user->can('update', $regionalParty)
        ) {
            // When you
            // - are a member of the regional party that manages the region page
            // - have update rights for that regional party
            //, you may update the region page
            return true;
        }

        return $user->managerCan('regionPage.update');
    }

    public function delete(IsManagerInterface $user, RegionPage $regionPage): bool
    {
        return $user->managerCan('regionPage.delete');
    }

    public function restore(IsManagerInterface $user, RegionPage $regionPage): bool
    {
        return $user->managerCan('regionPage.restore');
    }

    public function forceDelete(IsManagerInterface $user, RegionPage $regionPage): bool
    {
        return $user->managerCan('regionPage.forceDelete');
    }


    public function attachAnyContact(Authorizable $user, RegionPage $regionPage): bool
    {
        return $user->can('update', $regionPage);
    }
    public function attachContact(Authorizable $user, RegionPage $regionPage, Contact $contact): bool
    {
        return $user->can('attachAnyContact', $regionPage);
    }
    public function detachContact(Authorizable $user, RegionPage $regionPage, Contact $contact): bool
    {
        return $user->can('attachAnyContact', $regionPage);
    }
}
