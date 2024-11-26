<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ModelHelpers\InstrumentHelper;

class InstrumentResource extends ElasticResource
{
    /** @var Instrument */
    protected $resource;

    public function toArray(): array
    {
        $isComplete = InstrumentHelper::create($this->resource)->isComplete();

        return [
            'NaamInstrument' => $this->name,                                            // AN..200
            'UuidInstrument' => $this->uuid,                                            // AN36
            'SlugInstrument' => $this->slug,                                            // AN36

            'IndPublicatieInstrument' => Codelijsten::getJaNeeIndicatieCode($this->is_active),    // StdIndJN
            'DatBPublicatieInstrument' => $this->formatDate($this->publish_from),                 // DATUM
            'DatEPublicatieInstrument' => $this->formatDate($this->publish_to),                   // DATUM
            'IndCompleet' => Codelijsten::getJaNeeIndicatieCode($isComplete),                     // StdIndJN

            'Bewerkmoment' => BewerkmomentResource::one($this->resource),

            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->organisation),
            'Aanbieder' => AanbiederResource::one($this->provider),
            'Contactpersoon' => ContactpersoonResource::many($this->contacts),
            'Doelgroep' => DoelgroepResource::many($this->targetGroups),
            'Download' => DownloadResource::many($this->downloads),
            'Link' => LinkResource::many($this->links),
            'Registratiecode' => RegistratieCodeResource::many($this->registrationCodes),
            'Uitvoeringslocatie' => UitvoeringslocatieResource::many($this->locations),
            'Video' => VideoResource::many($this->videos),
            'WerklandschapTegel' => WerklandschapTegelResource::many($this->tiles),

            'CdBereikInstrument' => Codelijsten::getBereikCode($this->resource->getReachSGR()),
            'NaamBereikInstrument' => $this->resource->getReachSGR(),
            'IndLandelijk' => $this->resource->isNational(),
            'IndRegionaal' => $this->resource->isRegional(),
            'IndLokaal' => $this->resource->isLocal(),

            'BeschikbareGebieden' => GebiedResource::many($this->availableAreas),
            'OmvatteBeschikbareGebieden' => GebiedResource::many($this->allAvailableAreas),
            'OmvatteBeschikbareGebiedenGemeenten' => GebiedResource::many($this->allAvailableTownships),
        ];
    }
}
