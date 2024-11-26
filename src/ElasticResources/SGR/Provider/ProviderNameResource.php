<?php

namespace Vng\DennisCore\ElasticResources\SGR\Provider;

use Vng\DennisCore\ElasticResources\SGR\ElasticResource;

class ProviderNameResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamAanbieder' => $this->name,
        ];
    }
}
