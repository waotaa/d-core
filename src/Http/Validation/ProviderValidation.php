<?php

namespace Vng\DennisCore\Http\Validation;

class ProviderValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'organisation_id' => [
                'required',
            ],
            'name' => [
                'required',
            ],
        ];
    }
}
