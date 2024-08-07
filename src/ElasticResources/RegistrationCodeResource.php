<?php

namespace Vng\DennisCore\ElasticResources;

class RegistrationCodeResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'Registratiecode' => $this->code,
            'Registratiecodelabel' => $this->label,

            // todo: is_displayed toevoegen?

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
