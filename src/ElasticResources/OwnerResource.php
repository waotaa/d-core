<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Interfaces\IsOwnerInterface;

class OwnerResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'type' => $this->resource instanceof IsOwnerInterface ? $this->resource->getOwnerType() : null,
            'name' => $this->name,
            'slug' => $this->slug
        ];
    }
}
