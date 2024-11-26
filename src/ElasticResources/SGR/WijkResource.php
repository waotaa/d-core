<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class WijkResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamWijk' => $this->name,  // AN..200
            'Gemeente' => GemeenteResource::one($this->township),
        ];
    }
}
