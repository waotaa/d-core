<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Helpers\Codelijsten;

class TargetGroupResource extends ElasticResource
{
    public function toArray()
    {
        return [
            // >> SGR
            // todo: methode bepalen. Met codelijst of niet..?
            'IndEigenToevoegingDoelgroep' => $this->custom,
            'CdDoelgroep' => $this->code,

            // Bonus
            'NaamDoelgroep' => Codelijsten::getDoelgroepName($this->code),

            // >> Current
            'id' => $this->id,
            'description'  => $this->description,
            'code' => $this->code,
        ];
    }
}
