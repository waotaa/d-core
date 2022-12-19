<?php

namespace Vng\DennisCore\Http\Validation;

class DownloadValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'max:5000',
            ],
            'instrument_id' => [
                'required',
            ]
        ];
    }
}
