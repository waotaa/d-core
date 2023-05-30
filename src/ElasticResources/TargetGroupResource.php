<?php

namespace Vng\DennisCore\ElasticResources;

class TargetGroupResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'description'  => $this->description,
            'code' => $this->code,
        ];
    }
}
