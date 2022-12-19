<?php

namespace Vng\DennisCore\ElasticResources;

class SectorResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'description' => $this->description
        ];
    }
}
