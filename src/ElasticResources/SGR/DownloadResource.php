<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class DownloadResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'NaamDownload' => $this->label,
            'UrlDownload' => $this->cdnUrl,
            'Instrument' => InstrumentResource::many($this->whenLoaded('instruments')),
        ];
    }
}