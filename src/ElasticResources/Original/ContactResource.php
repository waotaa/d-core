<?php

namespace Vng\DennisCore\ElasticResources\Original;

use Vng\DennisCore\Helpers\Codelijsten;

class ContactResource extends ElasticResource
{
    public function toArray()
    {
        $pivot = $this->resource->pivot;
        $codeType = $pivot ? Codelijsten::getTypeContactPersoonRelatieCode($pivot->type) : null;

        $data = [
            // >> SGR
            'CdTypeContactpersoonRelatie' => $codeType,
            'EmailadresContactpersoon' => $this->email,         // AN..320
            'NaamContactpersoon' => $this->name,                // AN..200
            'TelefoonnummerContactpersoon' => $this->phone,     // AN..14

            'InstrumentBeherendeOrganisatie' => OrganisationResource::one($this->whenLoaded('organisation')),
            'InstrumentWerkgeversdienstverlening' => InstrumentWerkgeversdienstverleningResource::many($this->whenLoaded('instruments')),
            'Aanbieder' => ProviderResource::many($this->whenLoaded('providers')),

            // >> Current
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'type' => null,
            'label' => $this->resource?->pivot?->label,
        ];

        $pivot = $this->resource->pivot;
        if ($pivot) {
            $data['type'] = [
                'key' => $pivot->rawType,
                'name' => $pivot->type,
            ];
        }

        return $data;
    }
}
