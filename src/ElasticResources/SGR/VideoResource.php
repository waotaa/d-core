<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class VideoResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamVideo' => $this->name,
            'NaamAanbiederVideo' => $this->provider,
            'SleutelVideo' => $this->video_identifier,

            'Instrument' => InstrumentResource::one($this->whenLoaded('instrument')),
        ];
    }
}
