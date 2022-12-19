<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\ElasticResources\Township\RegionResource as TownshipRegionResource;

class TownshipResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' =>  $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'code' => $this->code,
            'featureId' => $this->featureId,
            'region' => $this->region ? TownshipRegionResource::one($this->region) : null,
        ];
    }
}
