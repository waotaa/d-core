<?php

namespace Vng\DennisCore\Http\Validation;

class LinkValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'url' => [
                'required',
                'url'
            ],
            'instrument_id' => [
                'required',
            ]
        ];
    }
}
