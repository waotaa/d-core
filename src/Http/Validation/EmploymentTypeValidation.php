<?php

namespace Vng\DennisCore\Http\Validation;

class EmploymentTypeValidation extends ModelValidation
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
