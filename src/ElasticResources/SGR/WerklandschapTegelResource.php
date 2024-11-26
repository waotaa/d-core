<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class WerklandschapTegelResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdWerklandschapTegel' => $this->code,
            'NaamWerklandschapTegel' => Codelijsten::getWerklandschapTegelName($this->code), // AN..200

            'ToelNaamWerklandschaptegel' => $this->sub_title,
            'SlugWerklandschaptegel' => $this->key,
            'KorteOmsWerklandschaptegel' => $this->excerpt,
            'OmsWerklandschaptegel' => $this->description,
        ];
    }
}
