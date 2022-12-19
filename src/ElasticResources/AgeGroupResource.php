<?php

namespace Vng\DennisCore\ElasticResources;

class AgeGroupResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'description' => $this->description
        ];
    }
}
