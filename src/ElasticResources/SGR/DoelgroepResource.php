<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class DoelgroepResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'IndEigenToevoegingDoelgroep' => Codelijsten::getJaNeeIndicatieCode($this->custom), // StdIndJN
            'CdDoelgroep' => $this->code,
            'NaamDoelgroep' => Codelijsten::getDoelgroepName($this->code),  // AN..200
        ];
    }
}
