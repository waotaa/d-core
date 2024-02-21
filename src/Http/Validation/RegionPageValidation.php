<?php

namespace Vng\DennisCore\Http\Validation;

class RegionPageValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'description' => [
                'string',
                'nullable',
            ],
            'cooperation_partners' => [
                'string',
                'nullable',
            ],
            'additional_information' => [
                'string',
                'nullable',
            ],
            'terminology' => [
                'string',
                'nullable',
            ],
            'region_id' => [
                'integer',
                'required',
            ],
            'regional_party_id' => [
                'integer',
                'nullable',
            ],
        ];
    }
}
