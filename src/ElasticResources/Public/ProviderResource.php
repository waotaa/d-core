<?php

namespace Vng\DennisCore\ElasticResources\Public;

class ProviderResource extends \Vng\DennisCore\ElasticResources\ProviderResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['contacts']);
        return $resource;
    }
}
