<?php

namespace Vng\DennisCore\ElasticResources\Public;

class InstrumentResource extends \Vng\DennisCore\ElasticResources\InstrumentResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['contacts']);
        return $resource;
    }
}
