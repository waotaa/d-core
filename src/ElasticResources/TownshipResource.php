<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\ElasticResources\Township\RegionResource as TownshipRegionResource;

class TownshipResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'CdGemeente' => substr($this->code, 2, 4),
            'NaamGemeente' => $this->name,              // AN..200

            'Arbeidsmarktregio' => $this->region ? TownshipRegionResource::one($this->region) : null,

            // >> Current
            'id' => $this->id,
            'name' =>  $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'description' => $this->description,
            'featureId' => $this->featureId,
            'region' => $this->region ? TownshipRegionResource::one($this->region) : null,
        ];
    }
}
