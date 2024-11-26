<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class RegionalePartijResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->whenLoaded('organisation')),
            'Arbeidsmarktregio' => ArbeidsmarktregioResource::one($this->whenLoaded('region')),
        ];
    }
}
