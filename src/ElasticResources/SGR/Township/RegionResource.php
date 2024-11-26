<?php

namespace Vng\DennisCore\ElasticResources\SGR\Township;

use Vng\DennisCore\ElasticResources\SGR\ElasticResource;

class RegionResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdArbeidsmarktregio' => substr($this->code, 2, 4),
            'NaamArbeidsmarktregio' => $this->name,
        ];
    }
}
