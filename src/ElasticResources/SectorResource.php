<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Helpers\Codelijsten;

class SectorResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'CdSectorInstrument' => $this->sbi_group,

            // Bonus
            'NaamSectorInstrument' => Codelijsten::getSectorName($this->sbi_group),

            // >> Current
            'id' => $this->id,
            'description' => $this->description,
            'sbi_group' => $this->sbi_group,
        ];
    }
}
