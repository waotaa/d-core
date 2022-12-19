<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Repositories\ManagerRepositoryInterface;

class UserObserver
{
    public function __construct(
        protected ManagerRepositoryInterface $managerRepository
    )
    {}

    public function creating(DennisUserInterface $user)
    {
        $user->assignRandomPassword();
    }

    /**
     * @param DennisUserInterface&IsManagerInterface $user
     * @return void
     */
    public function created(DennisUserInterface $user): void
    {
        $this->managerRepository->createForUser($user);
        $user->sendAccountCreationNotification();
    }

    public function deleted(IsManagerInterface $user): void
    {
        $this->managerRepository->delete($user->getManager()->id);
    }
}
