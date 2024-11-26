<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class LokalePartijResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->whenLoaded('organisation')),
            'Gemeente' => GemeenteResource::one($this->whenLoaded('township')),
        ];
    }
}
