<?php

namespace Vng\DennisCore\Http\Validation;

use Vng\DennisCore\Enums\FollowerRoleEnum;

class InstrumentTrackerValidation extends ModelValidation
{
    public function rules(): array
    {
        return [
            'role' => [
                'in:' . implode(',', FollowerRoleEnum::keys()),
            ],
            'instrument_id' => [
                'required',
            ],
            'manager_id' => [
                'required',
            ],
        ];
    }
}
