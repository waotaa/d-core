<?php

namespace Vng\DennisCore\ElasticResources\Original;

/** @deprecated  */
class TargetGroupRegisterResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'description' => $this->description
        ];
    }
}
