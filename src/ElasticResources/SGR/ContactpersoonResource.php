<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class ContactpersoonResource extends ElasticResource
{
    public function toArray()
    {
        $pivot = $this->resource->pivot;
        $codeType = $pivot ? Codelijsten::getTypeContactPersoonRelatieCode($pivot->type) : null;

        return [
            'NaamContactpersoon' => $this->name,                // AN..200
            'TelefoonnummerContactpersoon' => $this->phone,     // AN..14
            'EmailadresContactpersoon' => $this->email,         // AN..320
            'CdTypeContactpersoonRelatie' => $codeType,
            'OmsContactpersoon' => $this->description,          // AN..10000

            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->whenLoaded('organisation')),
            'InstrumentWerkgeversdienstverlening' => InstrumentWerkgeversdienstverleningResource::many($this->whenLoaded('instruments')),
            'Aanbieder' => AanbiederResource::many($this->whenLoaded('providers')),
        ];
    }
}
