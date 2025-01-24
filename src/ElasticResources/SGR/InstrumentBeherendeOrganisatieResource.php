<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class InstrumentBeherendeOrganisatieResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamInstrumentBeherendeOrganisatie' => $this->name,    // AN..200
            'SlugOrganisatie' => $this->slug,                       // AN..200
            'TypeOrganisatie' => $this->type,
            'CdTypeOrganisatie' => Codelijsten::getTypeOrganisatieCode($this->type),

            'LokalePartij' => LokalePartijResource::one($this->whenLoaded('localParty')),
            'RegionalePartij' => RegionalePartijResource::one($this->whenLoaded('regionalParty')),
            'NationalePartij' => LandelijkPartijResource::one($this->whenLoaded('nationalParty')),
            'Samenwerking' => SamenwerkingResource::one($this->whenLoaded('partnership')),

            'Contactpersoon' => ContactpersoonResource::many($this->whenLoaded('contacts')),
            'ActieveGebieden' => GebiedResource::many($this->resource->getAreasActiveInAttribute()),
        ];
    }
}
