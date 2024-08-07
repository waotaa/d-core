<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Helpers\Codelijsten;

class TileResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            'CdWerklandschapTegel' => $this->code,

            // Bonus
            'NaamWerklandschapTegel' => Codelijsten::getWerklandschapTegelName($this->code),

            // >> Current
            'id' => $this->id,
            'name'  => $this->name,
            'sub_title'  => $this->sub_title,
            'excerpt'  => $this->excerpt,
            'description'  => $this->description,
            'crisis_description'  => $this->crisis_description,
            'crisis_services'  => $this->crisis_services,
            'list'  => $this->list,
            'key'  => $this->key,
            'position'  => $this->position,
        ];
    }
}
