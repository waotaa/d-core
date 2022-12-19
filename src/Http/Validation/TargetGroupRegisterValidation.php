<?php

namespace Vng\DennisCore\Http\Validation;

class TargetGroupRegisterValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'description' => [
                'required'
            ]
        ];
    }
}
