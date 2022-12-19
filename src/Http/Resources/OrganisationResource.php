<?php

namespace Vng\DennisCore\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vng\DennisCore\Http\Resources\Organisation\LocalPartyResource as OrganisationLocalPartyResource;
use Vng\DennisCore\Http\Resources\Organisation\NationalPartyResource as OrganisationNationalPartyResource;
use Vng\DennisCore\Http\Resources\Organisation\PartnershipResource as OrganisationPartnershipResource;
use Vng\DennisCore\Http\Resources\Organisation\RegionalPartyResource as OrganisationRegionalPartyResource;

class OrganisationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'name' => $this->name,
            'type' => $this->type,

            'organisationable_type' => $this->organisationable_type,
            'organisationable_id' => $this->organisationable_id,

            'localParty' => OrganisationLocalPartyResource::make($this->localParty),
            'regionalParty' => OrganisationRegionalPartyResource::make($this->regionalParty),
            'nationalParty' => OrganisationNationalPartyResource::make($this->nationalParty),
            'partnership' => OrganisationPartnershipResource::make($this->partnership),

            'managers' => ManagerResource::collection($this->whenLoaded('managers')),
            'contacts' => ContactResource::collection($this->whenLoaded('contacts')),
        ];
    }
}
