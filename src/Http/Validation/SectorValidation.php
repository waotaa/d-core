<?php

namespace Vng\DennisCore\Http\Validation;

class SectorValidation extends ModelValidation
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
