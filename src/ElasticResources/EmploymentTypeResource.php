<?php

namespace Vng\DennisCore\ElasticResources;

class EmploymentTypeResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'code' => $this->code,

            // SGR
            'Code' => $this->code,
            'DienstverbandNaam' => $this->description,
        ];
    }
}
