<?php

namespace Vng\DennisCore\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AgeGroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'description'  => $this->description,

            'instruments' => InstrumentResource::collection($this->whenLoaded('instruments'))
        ];
    }
}
