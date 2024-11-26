<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class LandelijkPartijResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->whenLoaded('organisation')),
        ];
    }
}
