<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\OrganisationValidation;
use Vng\DennisCore\Models\Organisation;

class OrganisationUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('organisation'));
    }

    public function rules(): array
    {
        $organisation = $this->route('organisation');
        if (!$organisation instanceof Organisation) {
            throw new \Exception('Cannot derive organisation from route');
        }
        return OrganisationValidation::make($this)->getUpdateRules($organisation);
    }
}
