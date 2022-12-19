<?php


namespace Vng\DennisCore\Services\Instrument;

use Illuminate\Support\Facades\DB;
use Vng\DennisCore\Models\Instrument;

class InstrumentDuplicationService
{
    public static function copyInstrument(Instrument $instrumentToCopy): Instrument
    {
//        $instrumentToCopy = static::getCompleteInstrument($instrumentToCopy);
        $instrument = $instrumentToCopy->replicate();

        DB::transaction(function() use ($instrumentToCopy, $instrument) {
            $instrument->save();

            foreach ($instrumentToCopy->registrationCodes as $registrationCode) {
                $instrument->registrationCodes()->save($registrationCode->replicate());
            }
            foreach ($instrumentToCopy->locations as $location) {
                $instrument->locations()->save($location->replicate());
            }

            $instrument->availableRegions()->attach($instrumentToCopy->availableRegions);
            $instrument->availableTownships()->attach($instrumentToCopy->availableTownships);
            $instrument->availableNeighbourhoods()->attach($instrumentToCopy->availableNeighbourhoods);

            $instrument->ageGroups()->attach($instrumentToCopy->ageGroups);
            $instrument->employmentTypes()->attach($instrumentToCopy->employmentTypes);
            $instrument->sectors()->attach($instrumentToCopy->sectors);
            $instrument->targetGroupRegisters()->attach($instrumentToCopy->targetGroupRegisters);

            $instrument->targetGroups()->attach($instrumentToCopy->targetGroups);
            $instrument->tiles()->attach($instrumentToCopy->tiles);

            $instrument->contacts()->attach($instrumentToCopy->contacts);

            // Duplicate the content
            foreach ($instrumentToCopy->links as $link) {
                $instrument->links()->save($link->replicate());
            }
            foreach ($instrumentToCopy->videos as $video) {
                $instrument->videos()->save($video->replicate());
            }
            // Not the download for we don't duplicate the file yet
//            foreach ($instrumentToCopy->downloads as $download) {
//                $instrument->downloads()->save($download->replicate());
//            }
        });

        return $instrument;
    }
}
