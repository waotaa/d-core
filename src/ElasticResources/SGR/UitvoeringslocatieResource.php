<?php

namespace Vng\DennisCore\ElasticResources\SGR;

use Vng\DennisCore\Helpers\Codelijsten;

class UitvoeringslocatieResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'CdTypeUitvoeringslocatie' => Codelijsten::getUitvoeringLocatieCode($this->type),
            'IndUitvoeringslocatieActief' => Codelijsten::getJaNeeIndicatieCode($this->is_active),  // StdIndJN
            'NaamUitvoeringslocatie' => $this->name,            // AN..200
            'ToelUitvoeringslocatie' => $this->description,     // AN..320
            'Adres' => AdresResource::one($this->whenLoaded('address')),
            'InstrumentWerkgeversdienstverlening' => InstrumentWerkgeversdienstverleningResource::one($this->whenLoaded('instrument')),
        ];
    }
}
