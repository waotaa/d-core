<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Interfaces\OrganisationEntityInterface;

abstract class BaseOrganisationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * @param Model&IsManagerInterface $user
     * @param OrganisationEntityInterface $organisationEntity
     * @return bool
     */
    public function addInstrument(IsManagerInterface $user, OrganisationEntityInterface $organisationEntity): bool
    {
        return $user->can('addInstrument', $organisationEntity->getOrganisation());
    }

    /**
     * @param Model&IsManagerInterface $user
     * @param OrganisationEntityInterface $organisationEntity
     * @return bool
     */
    public function addProvider(IsManagerInterface $user, OrganisationEntityInterface $organisationEntity): bool
    {
        return $user->can('addProvider', $organisationEntity->getOrganisation());
    }
}
