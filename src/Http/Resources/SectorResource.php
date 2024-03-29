<?php

namespace Vng\DennisCore\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'description'  => $this->description,
            'sbi_group' => $this->sbi_group,

            // SGR / Dutch
            'sbiGroep' => $this->sbi_group,

            'instruments' => InstrumentResource::collection($this->whenLoaded('instruments'))
        ];
    }
}
