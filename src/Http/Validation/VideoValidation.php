<?php

namespace Vng\DennisCore\Http\Validation;

use Vng\DennisCore\Enums\VideoProviderEnum;

class VideoValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'provider' => [
                'in:' . implode(',', VideoProviderEnum::values()),
            ],
            'video_identifier' => [
                'max:11',
            ],
            'instrument_id' => [
                'required',
            ]
        ];
    }
}
