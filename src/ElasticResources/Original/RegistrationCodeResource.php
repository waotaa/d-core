<?php

namespace Vng\DennisCore\ElasticResources\Original;

use Vng\DennisCore\Helpers\Codelijsten;

class RegistrationCodeResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'Registratiecode' => $this->code,       // AN..34
            'Registratiecodelabel' => $this->label, // AN..200
            'IndWeergeven' => Codelijsten::getJaNeeNvtIndicatieCode($this->is_displayed),

            'InstrumentWerkgeversdienstverlening' => InstrumentWerkgeversdienstverleningResource::one($this->whenLoaded('instrument')),

            // >> Current
            'id' => $this->id,
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),

            'code' => $this->code,
            'label' => $this->label,
        ];
    }
}
