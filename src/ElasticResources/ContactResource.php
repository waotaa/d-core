<?php

namespace Vng\DennisCore\ElasticResources;

class ContactResource extends ElasticResource
{
    public function toArray()
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'type' => null,
            'label' => $this->resource?->pivot?->label,

            // SGR
            'ContactpersoonNaam' => $this->name,
            'Emailadres' => $this->email,
            'Telefoonnummer' => $this->phone,
            'RelatieType' => $this->resource?->pivot?->type,
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
