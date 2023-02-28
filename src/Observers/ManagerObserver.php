<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Manager;

class ManagerObserver
{
    public function creating(Manager $manager): void
    {
        /** @var IsManagerInterface $creatingUser */
        $creatingUser = request()->user();
        if ($creatingUser) {
            $creatingManager = $creatingUser->manager()->get();
            if ($creatingManager) {
                $manager->createdBy()->associate($creatingManager);
            }
        }
    }
}
