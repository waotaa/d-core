<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class RegistratieCodeResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'Registratiecode' => $this->code,       // AN..34
            'Registratiecodelabel' => $this->label, // AN..200
            'IndWeergeven' => Codelijsten::getJaNeeNvtIndicatieCode($this->is_displayed),

            'InstrumentWerkgeversdienstverlening' => InstrumentWerkgeversdienstverleningResource::one($this->whenLoaded('instrument')),
        ];
    }
}
