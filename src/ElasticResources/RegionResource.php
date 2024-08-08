<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\ElasticResources\Region\TownshipResource as RegionTownshipResource;
use Vng\DennisCore\Helpers\Codelijsten;

class RegionResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'CdArbeidsmarktregio' => substr($this->code, 2, 4),
            'NaamArbeidsmarktregio' => Codelijsten::getArbeidsmarktregioName($this->code), // AN..200
//            'NaamArbeidsmarktregio' => $this->name, // API name, codelist is leading

            'Gemeente' => RegionTownshipResource::many($this->townships),

            // >> Current
            'id' => $this->id,
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
            'deleted_at' => $this->formatDate($this->deleted_at),

            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'color' => $this->color,

            'townships' => TownshipResource::many($this->townships),
            'contacts' => ContactResource::many($this->contacts),

            // SGR
            'ArbeidsmarktregioNaam' => $this->name,
        ];
    }
}
