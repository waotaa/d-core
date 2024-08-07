<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Helpers\Codelijsten;

class AgeGroupResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'CdLeeftijdsgroep' => $this->code,

            // Bonus
            'NaamLeeftijdsgroep' => Codelijsten::getLeeftijdsgroepName($this->code),

            // >> Current
            'id' => $this->id,
            'description' => $this->description,
            'code' => $this->code,
        ];
    }
}
