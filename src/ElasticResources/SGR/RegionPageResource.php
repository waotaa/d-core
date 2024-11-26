<?php

namespace Vng\DennisCore\ElasticResources\SGR;

/**
 * Niet in SGR - enkel voor onze eigen portaal uiting
 */
class RegionPageResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,

            'description' => $this->description,
            'cooperation_partners' => $this->cooperation_partners,
            'additional_information' => $this->additional_information,
            'terminology' => $this->terminology,

            'region' => ArbeidsmarktregioResource::one($this->region),
            'regionalParty' => RegionalePartijResource::one($this->regionalParty),
            'contacts' => ContactpersoonResource::many($this->contacts),
        ];
    }
}
