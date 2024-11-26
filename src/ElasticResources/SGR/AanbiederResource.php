<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class AanbiederResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamAanbieder' => $this->name, // AN..200
            'UuidAanbieder' => $this->uuid, // AN36

            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->whenLoaded('organisation')),
            'Adres' => AdresResource::one($this->whenLoaded('address')),
            'Contactpersoon' => ContactpersoonResource::many($this->whenLoaded('contacts')),
        ];
    }
}
