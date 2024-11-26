<?php

namespace Vng\DennisCore\ElasticResources\Original\Public;

class RegionResource extends \Vng\DennisCore\ElasticResources\Original\RegionResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['contacts']);
        return $resource;
    }
}
