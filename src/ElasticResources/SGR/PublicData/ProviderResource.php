<?php

namespace Vng\DennisCore\ElasticResources\SGR\PublicData;

class ProviderResource extends \Vng\DennisCore\ElasticResources\Original\ProviderResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['Contactpersoon']);
        return $resource;
    }
}
