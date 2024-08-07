<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Helpers\Codelijsten;

class EmploymentTypeResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'CdDienstverband' => $this->code,

            // Bonus
            'NaamDienstverband' => Codelijsten::getDienstverbandName($this->code),

            // >> Current
            'id' => $this->id,
            'description' => $this->description,
            'code' => $this->code,
        ];
    }
}
