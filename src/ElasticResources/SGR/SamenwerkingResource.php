<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class SamenwerkingResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->whenLoaded('organisation')),
            'Gemeenten' => GemeenteResource::many($this->whenLoaded('townships')),
        ];
    }
}
