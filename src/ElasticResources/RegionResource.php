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

            'description' => $this->description,
            'cooperation_partners' => $this->cooperation_partners,
            'additional_information' => $this->additional_information,
            'terminology' => $this->terminology,

            'townships' => TownshipResource::many($this->townships),
            'contacts' => ContactResource::many($this->contacts),
        ];
    }
}
