<?php

namespace Vng\DennisCore\ElasticResources;

class RegistrationCodeResource extends ElasticResource
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'label' => $this->label,

            // SGR
            'Registratiecode' => $this->code,
            'RegistratiecodeLabel' => $this->label,
        ];
    }
}
