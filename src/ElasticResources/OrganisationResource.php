<?php

namespace Vng\DennisCore\ElasticResources;

class OrganisationResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'NaamInstrumentBeherendeOrganisatie' => $this->name,
            'OrganisatieSlug' => $this->slug,

            'LokalePartij' => LocalPartyResource::one($this->whenLoaded('localParty')),
            'RegionalePartij' => RegionalPartyResource::one($this->whenLoaded('regionalParty')),
            'NationalePartij' => NationalPartyResource::one($this->whenLoaded('nationalParty')),
            'Samenwerking' => PartnershipResource::one($this->whenLoaded('partnership')),

            'Contactpersoon' => ContactResource::many($this->whenLoaded('contacts')),

            // >> Current
            'id' => $this->id,
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
            'deleted_at' => $this->formatDate($this->deleted_at),

            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,

            'localParty' => LocalPartyResource::one($this->localParty),
            'regionalParty' => RegionalPartyResource::one($this->regionalParty),
            'nationalParty' => NationalPartyResource::one($this->nationalParty),
            'partnership' => PartnershipResource::one($this->partnership),

            'contacts' => ContactResource::many($this->contacts),

            'areasActiveIn' => AreaInterfaceResource::many($this->resource->getAreasActiveInAttribute()),
        ];
    }
}
