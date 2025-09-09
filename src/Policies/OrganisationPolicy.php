<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Interfaces\HasMembersInterface;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;
use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Organisation;

class OrganisationPolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user)
    {
        return true;
    }

    public function view(IsManagerInterface $user)
    {
        return true;
    }

    public function create(IsManagerInterface $user)
    {
        return false;
    }

    public function update(IsManagerInterface $user)
    {
        return false;
    }

    public function delete(IsManagerInterface $user)
    {
        return false;
    }

    /**
     * @param Model&IsManagerInterface $user
     * @param Organisation $organisation
     * @return bool
     */
    private function canAssignManagerToOrganisation(IsManagerInterface $user, Organisation $organisation): bool
    {
        $manager = $user->getManager();
        if ($user->managerCan('organisation.assign-manager.within-organisation')
            && $organisation->hasMember($manager)
        ) {
            return true;
        }
        return $user->managerCan('organisation.assign-manager');
    }

    /**
     * @param Model&IsManagerInterface $user
     * @param Organisation $organisation
     * @return bool
     */
    public function attachAnyManager(IsManagerInterface $user, Organisation $organisation): bool
    {
        return $this->canAssignManagerToOrganisation($user, $organisation);
    }

    public function attachManager(IsManagerInterface $user, Organisation $organisation, Manager $targetManager): bool
    {
        if ($user->getManager()->hasManagingRelation($targetManager)
            && $this->canAssignManagerToOrganisation($user, $organisation)
        ) {
            return true;
        }
        return $user->managerCan('organisation.assign-manager');
    }

    public function detachManager(IsManagerInterface $user, Organisation $organisation, Manager $targetManager): bool
    {
        if ($user->getManager()->hasManagingRelation($targetManager)
            && $this->canAssignManagerToOrganisation($user, $organisation)
        ) {
            return true;
        }
        return $user->managerCan('organisation.assign-manager');
    }

    /**
     * @param Model&IsManagerInterface $user
     * @param Organisation $organisation
     * @return bool
     */
    public function addInstrument(IsManagerInterface $user, Organisation $organisation): bool
    {
        if ($user->managerCan('instrument.organisation.create')
            && $organisation->hasMember($user->getManager())
        ) {
            return true;
        }
        return $user->managerCan('instrument.create');
    }

    /**
     * @param Model&IsManagerInterface $user
     * @param Organisation $organisation
     * @return bool
     */
    public function addProvider(IsManagerInterface $user, Organisation $organisation): bool
    {
        if ($user->managerCan('provider.organisation.create')
            && $organisation->hasMember($user->getManager())
        ) {
            return true;
        }
        return $user->managerCan('provider.create');
    }

    /**
     * @param Model&IsManagerInterface $user
     * @param Organisation $organisation
     * @return bool
     */
    public function addContact(IsManagerInterface $user, Organisation $organisation): bool
    {
        if ($user->managerCan('contact.organisation.create')
            && $organisation->hasMember($user->getManager())
        ) {
            return true;
        }
        return $user->managerCan('contact.create');
    }
}
