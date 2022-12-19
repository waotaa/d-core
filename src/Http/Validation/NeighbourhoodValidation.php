<?php

namespace Vng\DennisCore\Http\Validation;

class NeighbourhoodValidation extends ModelValidation
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
