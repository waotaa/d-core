<?php

namespace Vng\DennisCore\Services;

use Vng\DennisCore\Models\LocalParty;
use Vng\DennisCore\Models\Neighbourhood;
use Vng\DennisCore\Models\Township;

class TownshipReallocationService
{
    public static function transfer(Township $currentTownship, Township $newTownship)
    {
        $currentTownship->localParties()->each(
            fn (LocalParty $localParty) => $localParty->township()->associate($newTownship)->saveQuietly()
        );

        $currentTownship->neighbourhoods()->each(
            fn (Neighbourhood $neighbourhood) => $neighbourhood->township()->associate($newTownship)->saveQuietly()
        );
    }
}
