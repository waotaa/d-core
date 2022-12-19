<?php

namespace Vng\DennisCore\Http\Validation;

class NationalPartyValidation extends ModelValidation
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
