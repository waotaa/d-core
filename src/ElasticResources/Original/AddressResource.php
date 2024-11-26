<?php

namespace Vng\DennisCore\ElasticResources\Original;

class AddressResource extends ElasticResource
{
    public function toArray()
    {
        $adresNederland = [];

        if ($this->resource->isPostbusAdres()) {
            $adresNederland['Postadres'] = [
                'Postbusnr' => $this->postbusnummer         // N5
            ];
        }
        if ($this->resource->isAntwoordNrAdres()) {
            $adresNederland['Antwoordnradres'] = [
                'Antwoordnummer' => $this->antwoordnummer,  // N5
            ];
        }
        if ($this->resource->isStraatAdres()) {
            $adresNederland['Straatadres'] = [
                'Huisnr' => $this->huisnummer,                      // N..5
                'Huisnrtoevoeging' => $this->huisnummertoevoeging,  // AN..6
                'NaamOpenbareRuimte' => $this->straatnaam,          // AN..80
                'Straatnaam' => $this->straatnaam,                  // AN..24
            ];
        }

        return [
            // >> SGR
            'AdresNederland' => [
                'Locatieoms' => $this->name,                // AN..70
                'Postcd' => $this->postcode,                // AN6
                'Woonplaatsnaam' => $this->woonplaats,      // AN..80
                ...$adresNederland
            ],

            'InstrumentBeherendeOrganisatie' => OrganisationResource::one($this->whenLoaded('organisation')),

            // >> Current
            'id' => $this->id,
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
            'name' => $this->name,
            'straatnaam' => $this->straatnaam,
            'huisnummer' => $this->huisnummer,
            'postbusnummer' => $this->postbusnummer,
            'antwoordnummer' => $this->antwoordnummer,
            'postcode' => $this->postcode,
            'postcode_digits' => (int) substr($this->postcode, 0, 4),
            'woonplaats' => $this->woonplaats,
        ];
    }
}
