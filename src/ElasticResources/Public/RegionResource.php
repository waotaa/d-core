<?php

namespace Vng\DennisCore\ElasticResources\Public;

class RegionResource extends \Vng\DennisCore\ElasticResources\RegionResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['contacts']);
        return $resource;
    }
}
