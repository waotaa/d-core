<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class LinkResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamLink' => $this->label,
            'UrlLink' => $this->url,
            'Instrument' => InstrumentResource::one($this->whenLoaded('instrument')),
        ];
    }
}
