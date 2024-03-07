<?php

namespace Vng\DennisCore\ElasticResources;

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

            'region' => RegionResource::one($this->region),
            'regionalParty' => RegionalPartyResource::one($this->regionalParty),
            'contacts' => ContactResource::many($this->contacts),
        ];
    }
}
