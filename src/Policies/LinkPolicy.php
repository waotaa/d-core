<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Link;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user)
    {
        return true;
    }

    /**
     * @param IsManagerInterface&Authorizable $user
     * @param Link $link
     * @return mixed
     */
    public function view(IsManagerInterface $user, Link $link)
    {
        return $user->can('view', $link->instrument);
    }

    public function create(IsManagerInterface $user)
    {
        return true;
    }

    /**
     * @param IsManagerInterface&Authorizable $user
     * @param Link $link
     * @return mixed
     */
    public function update(IsManagerInterface $user, Link $link)
    {
        return $user->can('update', $link->instrument);
    }

    /**
     * @param IsManagerInterface&Authorizable $user
     * @param Link $link
     * @return mixed
     */
    public function delete(IsManagerInterface $user, Link $link)
    {
        return $user->can('update', $link->instrument);
    }
}
