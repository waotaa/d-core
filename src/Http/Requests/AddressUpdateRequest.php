<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\AddressValidation;
use Vng\DennisCore\Models\Address;

class AddressUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('address'));
    }

    public function rules(): array
    {
        $address = $this->route('address');
        if (!$address instanceof Address) {
            throw new \Exception('Cannot derive address from route');
        }
        return AddressValidation::make($this)->getUpdateRules($address);
    }
}
