<?php

namespace Vng\DennisCore\ElasticResources\SGR\Region;

use Vng\DennisCore\ElasticResources\SGR\ElasticResource;

class TownshipResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdGemeente' => substr($this->code, 2, 4),
            'NaamGemeente' => $this->name,
        ];
    }
}
