<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class LeeftijdsgroepResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdLeeftijdsgroep' => $this->code,
            'NaamLeeftijdsgroep' => Codelijsten::getLeeftijdsgroepName($this->code), // AN..200
        ];
    }
}
