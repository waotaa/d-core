<?php

namespace Vng\DennisCore\ElasticResources\Public;

/**
 * An Instrument Resource with some properties withheld.
 * Used for the public index (used on kibana board)
 */
class InstrumentWerkgeversdienstverleningResource extends \Vng\DennisCore\ElasticResources\InstrumentWerkgeversdienstverleningResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['contacts']);
        return $resource;
    }
}
