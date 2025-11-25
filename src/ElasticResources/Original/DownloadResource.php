<?php

namespace Vng\DennisCore\ElasticResources\Original;

class DownloadResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'label' => $this->label,
            'url' => $this->cdnUrl,
            'filename' => $this->filename,
        ];
    }
}
