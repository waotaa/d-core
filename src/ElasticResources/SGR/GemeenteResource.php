<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\ElasticResources\SGR\Township\RegionResource as TownshipRegionResource;

class GemeenteResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdGemeente' => substr($this->code, 2, 4),
            'NaamGemeente' => $this->name,              // AN..200

            'Arbeidsmarktregio' => $this->region ? TownshipRegionResource::one($this->region) : null,
        ];
    }
}
