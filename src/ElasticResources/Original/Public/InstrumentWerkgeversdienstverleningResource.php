<?php

namespace Vng\DennisCore\ElasticResources\Original\Public;

/**
 * An Instrument Resource with some properties withheld.
 * Used for the public index (used on kibana board)
 */
class InstrumentWerkgeversdienstverleningResource extends \Vng\DennisCore\ElasticResources\Original\InstrumentWerkgeversdienstverleningResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['contacts']);
        return $resource;
    }
}
