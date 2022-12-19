<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\NationalPartyValidation;
use Vng\DennisCore\Models\NationalParty;

class NationalPartyUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('nationalParty'));
    }

    public function rules(): array
    {
        $nationalParty = $this->route('nationalParty');
        if (!$nationalParty instanceof NationalParty) {
            throw new \Exception('Cannot derive nationalParty from route');
        }
        return NationalPartyValidation::make($this)->getUpdateRules($nationalParty);
    }
}
