<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\RegistrationCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistrationCodePolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user)
    {
        return true;
    }

    /**
     * @param IsManagerInterface&Authorizable $user
     * @param RegistrationCode $registrationCode
     * @return mixed
     */
    public function view(IsManagerInterface $user, RegistrationCode $registrationCode)
    {
        return $user->can('view', $registrationCode->instrument);
    }

    public function create(IsManagerInterface $user)
    {
        return true;
    }

    /**
     * @param IsManagerInterface&Authorizable $user
     * @param RegistrationCode $registrationCode
     * @return mixed
     */
    public function update(IsManagerInterface $user, RegistrationCode $registrationCode)
    {
        return $user->can('update', $registrationCode->instrument);
    }

    /**
     * @param IsManagerInterface&Authorizable $user
     * @param RegistrationCode $registrationCode
     * @return mixed
     */
    public function delete(IsManagerInterface $user, RegistrationCode $registrationCode)
    {
        return $user->can('update', $registrationCode->instrument);
    }
}
