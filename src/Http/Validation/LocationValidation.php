<?php

namespace Vng\DennisCore\Http\Validation;

use Vng\DennisCore\Enums\LocationEnum;

class LocationValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'type' => [
                'in:' . implode(',', LocationEnum::keys()),
                'nullable'
            ],
            'is_active' => [
                'boolean'
            ],
            'address_id' => [
                'required_if:type,Adres',
                'prohibited_if:type,Klant thuis'
            ],
            'instrument_id' => [
                'required'
            ]
        ];
    }
}
