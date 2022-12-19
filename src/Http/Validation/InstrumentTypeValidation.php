<?php

namespace Vng\DennisCore\Http\Validation;

class InstrumentTypeValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'key' => [
                'required',
                'regex:/^IT-\d+$/'
            ],
        ];
    }
}
