<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class SectorResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdSectorInstrument' => $this->sbi_group,
            'NaamSectorInstrument' => Codelijsten::getSectorName($this->sbi_group),
        ];
    }
}
