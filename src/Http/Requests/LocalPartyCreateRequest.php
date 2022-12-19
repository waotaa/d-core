<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\LocalPartyValidation;
use Vng\DennisCore\Models\LocalParty;

class LocalPartyCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', LocalParty::class);
    }

    public function rules(): array
    {
        return LocalPartyValidation::make($this)->getCreationRules();
    }
}
