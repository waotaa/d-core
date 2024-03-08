<?php

namespace Vng\DennisCore\Observers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
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
        if (!App::runningUnitTests()) {
            $user->sendAccountCreationNotification();
        }
    }

    public function deleted(IsManagerInterface $user)
    {
        if (!in_array(SoftDeletes::class, class_uses_recursive(get_class($user)))) {
            // No softdeletes used, hard delete user
            $this->hardDelete($user);
        }
    }

    public function forceDeleted(IsManagerInterface $user)
    {
        $this->hardDelete($user);
    }

    protected function hardDelete(IsManagerInterface $user)
    {
        $manager = $user->getManager();
        if (!is_null($manager)) {
            $this->managerRepository->delete($manager->id);
        }
    }

}
