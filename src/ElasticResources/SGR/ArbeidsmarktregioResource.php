<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\ElasticResources\Original\Region\TownshipResource as RegionTownshipResource;
use Vng\DennisCore\Helpers\Codelijsten;

class ArbeidsmarktregioResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdArbeidsmarktregio' => substr($this->code, 2, 4),
            'NaamArbeidsmarktregio' => Codelijsten::getArbeidsmarktregioName($this->code), // AN..200
//            'NaamArbeidsmarktregio' => $this->name, // API name, codelist is leading

            'Gemeente' => RegionTownshipResource::many($this->townships),
        ];
    }
}
