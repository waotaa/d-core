<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\RegistrationCodeValidation;
use Vng\DennisCore\Models\RegistrationCode;

class RegistrationCodeUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('registrationCode'));
    }

    public function rules(): array
    {
        $registrationCode = $this->route('registrationCode');
        if (!$registrationCode instanceof RegistrationCode) {
            throw new \Exception('Cannot derive registrationCode from route');
        }
        return RegistrationCodeValidation::make($this)->getUpdateRules($registrationCode);
    }
}
