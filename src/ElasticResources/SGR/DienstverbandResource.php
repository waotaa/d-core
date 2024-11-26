<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class DienstverbandResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdDienstverband' => $this->code,
            'NaamDienstverband' => Codelijsten::getDienstverbandName($this->code),  // AN..200
        ];
    }
}
