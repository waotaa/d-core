<?php

namespace Vng\DennisCore\ElasticResources\Original\Provider;

use Vng\DennisCore\ElasticResources\Original\ElasticResource;

class ProviderNameResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'NaamAanbieder' => $this->name,

            // >> Current
            'name' => $this->name,
        ];
    }
}
