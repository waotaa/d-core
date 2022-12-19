<?php

namespace Vng\DennisCore\Http\Validation;

class AgeGroupValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'description' => [
                'required',
            ],
        ];
    }
}
