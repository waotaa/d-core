<?php

namespace Vng\DennisCore\Http\Validation;

class LocalPartyValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'township_id' => [
                'required',
            ],
        ];
    }
}
