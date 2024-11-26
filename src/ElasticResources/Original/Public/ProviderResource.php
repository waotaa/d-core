<?php

namespace Vng\DennisCore\ElasticResources\Original\Public;

class ProviderResource extends \Vng\DennisCore\ElasticResources\Original\ProviderResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['Contactpersoon']);
        unset($resource['contacts']);
        return $resource;
    }
}
