<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\LocalPartyValidation;
use Vng\DennisCore\Models\LocalParty;

class LocalPartyUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('localParty'));
    }

    public function rules(): array
    {
        $localParty = $this->route('localParty');
        if (!$localParty instanceof LocalParty) {
            throw new \Exception('Cannot derive localParty from route');
        }
        return LocalPartyValidation::make($this)->getUpdateRules($localParty);
    }
}
