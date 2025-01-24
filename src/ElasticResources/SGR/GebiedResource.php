<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;
use Vng\DennisCore\Interfaces\AreaInterface;

class GebiedResource extends ElasticResource
{
    /** @var AreaInterface */
    protected $resource;

    public function toArray()
    {
        return [
            'NaamGebied' => $this->resource->getAreaName(),
            'CdTypeGebied' => Codelijsten::getTypeGebiedCode($this->resource->getAreaTypeSGR()),
            'NaamTypeGebied' => $this->resource->getAreaTypeSGR(),
        ];
    }
}
