<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\NationalPartyValidation;
use Vng\DennisCore\Http\Validation\PartnershipValidation;
use Vng\DennisCore\Models\NationalParty;
use Vng\DennisCore\Models\Partnership;

class PartnershipCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Partnership::class);
    }

    public function rules(): array
    {
        return PartnershipValidation::make($this)->getCreationRules();
    }
}
