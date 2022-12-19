<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Repositories\Eloquent\ManagerRepository;

class ManagerObserver
{
    public function creating(Manager $manager): void
    {
        /** @var IsManagerInterface $creatingUser */
        $creatingUser = request()->user();
        $creatingManager = $creatingUser->manager()->get();

        if ($creatingManager) {
            $manager->createdBy()->associate($creatingManager);
        }
    }
}
