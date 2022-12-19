<?php

namespace Vng\DennisCore\Http\Validation;

class NewsItemValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
            ],
            'body' => [
                'required',
            ],
            'environment_id' => [
                'required',
            ],
        ];
    }
}
