<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\AddressValidation;
use Vng\DennisCore\Models\Address;

class AddressCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Address::class);
    }

    public function rules(): array
    {
        return AddressValidation::make($this)->getCreationRules();
    }
}
