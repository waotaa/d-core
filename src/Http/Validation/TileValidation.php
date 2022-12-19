<?php

namespace Vng\DennisCore\Http\Validation;

class TileValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'sub_title' => [
                'required',
            ],
            'description' => [
                'required',
            ],
            'list' => [
                'required',
            ],
        ];
    }
}
