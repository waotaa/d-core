<?php

namespace Vng\DennisCore\Http\Validation;

class InstrumentValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'name' => [
                'required'
            ],
            'short_description' => [
                'required',
                'max:500'
            ],
            'description' => [
                'required',
            ],
            'applications' => [
                'required'
            ],
            'conditions' => [
                'required'
            ],
            'organisation_id' => [
                'required'
            ],
            'provider_id' => [
                'required',
            ],
        ];
    }
}
