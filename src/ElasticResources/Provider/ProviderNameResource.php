<?php

namespace Vng\DennisCore\ElasticResources\Provider;

use Vng\DennisCore\ElasticResources\ElasticResource;

class ProviderNameResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
