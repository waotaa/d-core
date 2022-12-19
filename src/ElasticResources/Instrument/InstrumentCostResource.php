<?php

namespace Vng\DennisCore\ElasticResources\Instrument;

use Vng\DennisCore\ElasticResources\ElasticResource;
use Vng\DennisCore\ElasticResources\Provider\ProviderNameResource;

class InstrumentCostResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'name' => $this->name,
            'total_costs' => $this->total_costs,
            'provider' => ProviderNameResource::many($this->provider),
//            'providers' => ProviderNameResource::many($this->providers),
        ];
    }
}
