<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Region;

class RegionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user): bool
    {
        return $user->managerCan('region.viewAny');
    }

    public function view(IsManagerInterface $user, Region $region): bool
    {
        return $user->managerCan('region.view');
    }

    public function create(IsManagerInterface $user): bool
    {
        return false;
    }

    public function update(IsManagerInterface $user, Region $region): bool
    {
        return $user->managerCan('region.update');
    }

    public function delete(IsManagerInterface $user, Region $region): bool
    {
        return false;
    }

    public function restore(IsManagerInterface $user, Region $region): bool
    {
        return $user->managerCan('region.restore');
    }

    public function forceDelete(IsManagerInterface $user, Region $region): bool
    {
        return false;
    }


    public function attachAnyContact(Authorizable $user, Region $region): bool
    {
        return $user->can('update', $region);
    }
    public function attachContact(Authorizable $user, Region $region, Contact $contact): bool
    {
        return $user->can('attachAnyContact', $region);
    }
    public function detachContact(Authorizable $user, Region $region, Contact $contact): bool
    {
        return $user->can('attachAnyContact', $region);
    }
}
