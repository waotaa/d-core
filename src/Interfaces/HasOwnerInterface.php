<?php

namespace Vng\DennisCore\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface HasOwnerInterface
{
    public function owner(): MorphTo;

    public function isOwnedByRegion(): bool;

    public function isOwnedByTownship(): bool;

    public function isOwnedByEnvironment(): bool;

    public function hasOwner(): bool;

    public function isOwnedByAdministrator(): bool;

    public function isUserMemberOfOwner(DennisUserInterface $user): bool;
}
