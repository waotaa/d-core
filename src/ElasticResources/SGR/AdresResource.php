<?php

namespace Vng\DennisCore\ElasticResources\SGR;

class AdresResource extends ElasticResource
{
    public function toArray()
    {
        $adresNederland = [
            'Locatieoms' => $this->name,                // AN..70
            'Postcd' => $this->postcode,                // AN6
            'Woonplaatsnaam' => $this->woonplaats,      // AN..80
        ];

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
            'AdresNederland' => $adresNederland,
            'InstrumentBeherendeOrganisatie' => InstrumentBeherendeOrganisatieResource::one($this->whenLoaded('organisation')),
        ];
    }
}
