<?php

namespace Vng\DennisCore\Http\Validation;

/**
 * @deprecated
 */
class AssociateableValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'user_id' => [
                'required'
            ],
            'assoociateable_type' => [
                'required'
            ],
            'assoociateable_id' => [
                'required'
            ],
        ];
    }
}
