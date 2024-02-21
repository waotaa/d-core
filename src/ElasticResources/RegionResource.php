<?php

namespace Vng\DennisCore\ElasticResources;

class RegionResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'color' => $this->color,

            'townships' => TownshipResource::many($this->townships),
            'contacts' => ContactResource::many($this->contacts),
        ];
    }
}
