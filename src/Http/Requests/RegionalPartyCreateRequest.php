<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\RegionalPartyValidation;
use Vng\DennisCore\Models\RegionalParty;

class RegionalPartyCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', RegionalParty::class);
    }

    public function rules(): array
    {
        return RegionalPartyValidation::make($this)->getCreationRules();
    }
}
