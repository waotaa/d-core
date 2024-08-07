<?php

namespace Vng\DennisCore\ElasticResources\Township;

use Vng\DennisCore\ElasticResources\ElasticResource;

class RegionResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'CdArbeidsmarktregio' => substr($this->code, 2, 4),
            'NaamArbeidsmarktregio' => $this->name,

            // >> Current
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'description' => $this->description,
            'color' => $this->color,
            'cooperation_partners' => $this->cooperation_partners,

            'townships' => $this->townships->pluck('name'),
        ];
    }
}
