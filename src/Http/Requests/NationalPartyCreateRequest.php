<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\NationalPartyValidation;
use Vng\DennisCore\Models\NationalParty;

class NationalPartyCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', NationalParty::class);
    }

    public function rules(): array
    {
        return NationalPartyValidation::make($this)->getCreationRules();
    }
}
