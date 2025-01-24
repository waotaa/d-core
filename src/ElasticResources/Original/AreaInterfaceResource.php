<?php

namespace Vng\DennisCore\ElasticResources\Original;

use Vng\DennisCore\Interfaces\AreaInterface;

class AreaInterfaceResource extends ElasticResource
{
    /** @var AreaInterface */
    protected $resource;

    public function toArray()
    {
        return [
            'identifier' => $this->resource->getAreaIdentifier(),
            'name' => $this->resource->getAreaName(),
            'slug' => $this->resource->getAreaSlug(),
            'type' => $this->resource->getAreaType(),
        ];
    }
}
