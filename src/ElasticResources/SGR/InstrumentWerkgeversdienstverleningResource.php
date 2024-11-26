<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Illuminate\Support\Str;
use Vng\DennisCore\Helpers\Codelijsten;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ModelHelpers\InstrumentHelper;

class InstrumentWerkgeversdienstverleningResource extends ElasticResource
{
    /** @var Instrument */
    protected $resource;

    public function toArray()
    {
        $targetGroupRegister = null;
        if ($this->targetGroupRegisters->count() !== 0) {
            $targetGroupRegister = $this->targetGroupRegisters->filter(fn ($tgr) => $tgr->description === 'Ja')->count() === 1;
        }

        return [
            'Instrument' => InstrumentResource::one($this->resource),

            'IndDoelgroepsRegister' => Codelijsten::getJaNeeNvtIndicatieCode($targetGroupRegister),  // StdIndNvt
            'IndLeerwerktraject' => Codelijsten::getJaNeeIndicatieCode($this->is_leerwerktraject),  // StdIndJN
            'IndTijdelijk' => Codelijsten::getJaNeeIndicatieCode($this->is_temporary),              // StdIndJN
            'OmsAanvraag' => $this->applications,               // AN..320 - 2785
            'OmsInstrument' => $this->description,              // AN..320 - 11757
            'OmsKortInstrument' => $this->short_description,    // AN..320 - 1751
            'OmsVoorwaarden' => $this->conditions,              // AN..320 - 5177

            'Dienstverband' => DienstverbandResource::many($this->employmentTypes),
            'Leeftijdsgroep' => LeeftijdsgroepResource::many($this->ageGroups),
            'Sector' => SectorResource::many($this->sectors),
        ];
    }
}
