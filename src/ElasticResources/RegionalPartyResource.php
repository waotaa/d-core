<?php

namespace Vng\DennisCore\ElasticResources;

class RegionalPartyResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'region' => RegionResource::one($this->region),
        ];
    }
}
