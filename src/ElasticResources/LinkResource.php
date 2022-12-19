<?php

namespace Vng\DennisCore\ElasticResources;

class LinkResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'url' => $this->url,
        ];
    }
}
