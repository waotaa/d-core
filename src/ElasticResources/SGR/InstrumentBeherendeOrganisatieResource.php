<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class InstrumentBeherendeOrganisatieResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamInstrumentBeherendeOrganisatie' => $this->name,    // AN..200
            'OrganisatieSlug' => $this->slug,                       // AN..200

            'LokalePartij' => LokalePartijResource::one($this->whenLoaded('localParty')),
            'RegionalePartij' => RegionalePartijResource::one($this->whenLoaded('regionalParty')),
            'NationalePartij' => LandelijkPartijResource::one($this->whenLoaded('nationalParty')),
            'Samenwerking' => SamenwerkingResource::one($this->whenLoaded('partnership')),

            'Contactpersoon' => ContactpersoonResource::many($this->whenLoaded('contacts')),
        ];
    }
}
