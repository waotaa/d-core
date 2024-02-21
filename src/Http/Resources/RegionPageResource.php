<?php

namespace Vng\DennisCore\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionPageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'description' => $this->description,
            'cooperation_partners' => $this->cooperation_partners,
            'additional_information' => $this->additional_information,
            'terminology' => $this->terminology,

            'region' => RegionResource::make($this->region),
            'regionalParty' => RegionalPartyResource::collection($this->whenLoaded('regionalParty')),
            'contacts' => ContactResource::collection($this->whenLoaded('contacts')),
        ];
    }
}
