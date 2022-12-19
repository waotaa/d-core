<?php

namespace Vng\DennisCore\Http\Validation;

class RegionalPartyValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'region_id' => [
                'required',
            ],
        ];
    }
}
