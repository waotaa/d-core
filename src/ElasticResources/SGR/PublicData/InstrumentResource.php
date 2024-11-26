<?php

namespace Vng\DennisCore\ElasticResources\SGR\PublicData;

/**
 * An Instrument Resource with some properties withheld.
 * Used for the public index (used on kibana board)
 */
class InstrumentResource extends \Vng\DennisCore\ElasticResources\Original\InstrumentWerkgeversdienstverleningResource
{
    public function toArray()
    {
        $resource = parent::toArray();
        unset($resource['contacts']);
        return $resource;
    }
}
