<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\OrganisationValidation;
use Vng\DennisCore\Models\Organisation;

class OrganisationCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Organisation::class);
    }

    public function rules(): array
    {
        return OrganisationValidation::make($this)->getCreationRules();
    }
}
