<?php

namespace Vng\DennisCore\Http\Validation;

class ClientCharacteristicValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
        ];
    }
}
